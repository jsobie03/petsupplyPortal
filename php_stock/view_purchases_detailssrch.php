<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "view_purchases_detailsinfo.php" ?>
<?php include_once "a_stock_itemsinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$view_purchases_details_search = NULL; // Initialize page object first

class cview_purchases_details_search extends cview_purchases_details {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'view_purchases_details';

	// Page object name
	var $PageObjName = 'view_purchases_details_search';

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

		// Table object (view_purchases_details)
		if (!isset($GLOBALS["view_purchases_details"]) || get_class($GLOBALS["view_purchases_details"]) == "cview_purchases_details") {
			$GLOBALS["view_purchases_details"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["view_purchases_details"];
		}

		// Table object (a_stock_items)
		if (!isset($GLOBALS['a_stock_items'])) $GLOBALS['a_stock_items'] = new ca_stock_items();

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'view_purchases_details', TRUE);

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
		if (!isset($_SESSION['table_view_purchases_details_views'])) { 
			$_SESSION['table_view_purchases_details_views'] = 0;
		}
		$_SESSION['table_view_purchases_details_views'] = $_SESSION['table_view_purchases_details_views']+1;

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
				$this->Page_Terminate(ew_GetUrl("view_purchases_detailslist.php"));
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
		$this->Purchase_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $view_purchases_details;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($view_purchases_details);
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
						$sSrchStr = "view_purchases_detailslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Purchase_ID); // Purchase_ID
		$this->BuildSearchUrl($sSrchUrl, $this->Purchase_Number); // Purchase_Number
		$this->BuildSearchUrl($sSrchUrl, $this->Supplier_Number); // Supplier_Number
		$this->BuildSearchUrl($sSrchUrl, $this->Stock_Item); // Stock_Item
		$this->BuildSearchUrl($sSrchUrl, $this->Purchasing_Quantity); // Purchasing_Quantity
		$this->BuildSearchUrl($sSrchUrl, $this->Purchasing_Price); // Purchasing_Price
		$this->BuildSearchUrl($sSrchUrl, $this->Selling_Price); // Selling_Price
		$this->BuildSearchUrl($sSrchUrl, $this->Purchasing_Total_Amount); // Purchasing_Total_Amount
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
		// Purchase_ID

		$this->Purchase_ID->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Purchase_ID"));
		$this->Purchase_ID->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Purchase_ID");
		$this->Purchase_ID->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Purchase_ID");
		$this->Purchase_ID->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Purchase_ID"));
		$this->Purchase_ID->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Purchase_ID");

		// Purchase_Number
		$this->Purchase_Number->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Purchase_Number"));
		$this->Purchase_Number->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Purchase_Number");
		$this->Purchase_Number->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Purchase_Number");
		$this->Purchase_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Purchase_Number"));
		$this->Purchase_Number->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Purchase_Number");

		// Supplier_Number
		$this->Supplier_Number->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Supplier_Number"));
		$this->Supplier_Number->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Supplier_Number");
		$this->Supplier_Number->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Supplier_Number");
		$this->Supplier_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Supplier_Number"));
		$this->Supplier_Number->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Supplier_Number");

		// Stock_Item
		$this->Stock_Item->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Stock_Item"));
		$this->Stock_Item->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Stock_Item");
		$this->Stock_Item->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Stock_Item");
		$this->Stock_Item->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Stock_Item"));
		$this->Stock_Item->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Stock_Item");

		// Purchasing_Quantity
		$this->Purchasing_Quantity->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Purchasing_Quantity"));
		$this->Purchasing_Quantity->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Purchasing_Quantity");
		$this->Purchasing_Quantity->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Purchasing_Quantity");
		$this->Purchasing_Quantity->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Purchasing_Quantity"));
		$this->Purchasing_Quantity->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Purchasing_Quantity");

		// Purchasing_Price
		$this->Purchasing_Price->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Purchasing_Price"));
		$this->Purchasing_Price->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Purchasing_Price");
		$this->Purchasing_Price->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Purchasing_Price");
		$this->Purchasing_Price->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Purchasing_Price"));
		$this->Purchasing_Price->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Purchasing_Price");

		// Selling_Price
		$this->Selling_Price->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Selling_Price"));
		$this->Selling_Price->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Selling_Price");
		$this->Selling_Price->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Selling_Price");
		$this->Selling_Price->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Selling_Price"));
		$this->Selling_Price->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Selling_Price");

		// Purchasing_Total_Amount
		$this->Purchasing_Total_Amount->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Purchasing_Total_Amount"));
		$this->Purchasing_Total_Amount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Purchasing_Total_Amount");
		$this->Purchasing_Total_Amount->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Purchasing_Total_Amount");
		$this->Purchasing_Total_Amount->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Purchasing_Total_Amount"));
		$this->Purchasing_Total_Amount->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Purchasing_Total_Amount");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Purchasing_Quantity->FormValue == $this->Purchasing_Quantity->CurrentValue && is_numeric(ew_StrToFloat($this->Purchasing_Quantity->CurrentValue)))
			$this->Purchasing_Quantity->CurrentValue = ew_StrToFloat($this->Purchasing_Quantity->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Purchasing_Price->FormValue == $this->Purchasing_Price->CurrentValue && is_numeric(ew_StrToFloat($this->Purchasing_Price->CurrentValue)))
			$this->Purchasing_Price->CurrentValue = ew_StrToFloat($this->Purchasing_Price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Selling_Price->FormValue == $this->Selling_Price->CurrentValue && is_numeric(ew_StrToFloat($this->Selling_Price->CurrentValue)))
			$this->Selling_Price->CurrentValue = ew_StrToFloat($this->Selling_Price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Purchasing_Total_Amount->FormValue == $this->Purchasing_Total_Amount->CurrentValue && is_numeric(ew_StrToFloat($this->Purchasing_Total_Amount->CurrentValue)))
			$this->Purchasing_Total_Amount->CurrentValue = ew_StrToFloat($this->Purchasing_Total_Amount->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Purchase_ID
		// Purchase_Number
		// Supplier_Number
		// Stock_Item
		// Purchasing_Quantity
		// Purchasing_Price
		// Selling_Price
		// Purchasing_Total_Amount

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Purchase_ID
		$this->Purchase_ID->ViewValue = $this->Purchase_ID->CurrentValue;
		$this->Purchase_ID->ViewCustomAttributes = "";

		// Purchase_Number
		$this->Purchase_Number->ViewValue = $this->Purchase_Number->CurrentValue;
		$this->Purchase_Number->ViewCustomAttributes = "";

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
		$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
		$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
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

		// Purchasing_Quantity
		$this->Purchasing_Quantity->ViewValue = $this->Purchasing_Quantity->CurrentValue;
		$this->Purchasing_Quantity->ViewValue = ew_FormatNumber($this->Purchasing_Quantity->ViewValue, 0, -1, -1, -1);
		$this->Purchasing_Quantity->CellCssStyle .= "text-align: right;";
		$this->Purchasing_Quantity->ViewCustomAttributes = "";

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

		// Purchasing_Total_Amount
		$this->Purchasing_Total_Amount->ViewValue = $this->Purchasing_Total_Amount->CurrentValue;
		$this->Purchasing_Total_Amount->ViewValue = ew_FormatCurrency($this->Purchasing_Total_Amount->ViewValue, 2, -2, -2, -2);
		$this->Purchasing_Total_Amount->CellCssStyle .= "text-align: right;";
		$this->Purchasing_Total_Amount->ViewCustomAttributes = "";

			// Purchase_ID
			$this->Purchase_ID->LinkCustomAttributes = "";
			$this->Purchase_ID->HrefValue = "";
			$this->Purchase_ID->TooltipValue = "";

			// Purchase_Number
			$this->Purchase_Number->LinkCustomAttributes = "";
			$this->Purchase_Number->HrefValue = "";
			$this->Purchase_Number->TooltipValue = "";

			// Supplier_Number
			$this->Supplier_Number->LinkCustomAttributes = "";
			$this->Supplier_Number->HrefValue = "";
			$this->Supplier_Number->TooltipValue = "";

			// Stock_Item
			$this->Stock_Item->LinkCustomAttributes = "";
			$this->Stock_Item->HrefValue = "";
			$this->Stock_Item->TooltipValue = "";

			// Purchasing_Quantity
			$this->Purchasing_Quantity->LinkCustomAttributes = "";
			$this->Purchasing_Quantity->HrefValue = "";
			$this->Purchasing_Quantity->TooltipValue = "";

			// Purchasing_Price
			$this->Purchasing_Price->LinkCustomAttributes = "";
			$this->Purchasing_Price->HrefValue = "";
			$this->Purchasing_Price->TooltipValue = "";

			// Selling_Price
			$this->Selling_Price->LinkCustomAttributes = "";
			$this->Selling_Price->HrefValue = "";
			$this->Selling_Price->TooltipValue = "";

			// Purchasing_Total_Amount
			$this->Purchasing_Total_Amount->LinkCustomAttributes = "";
			$this->Purchasing_Total_Amount->HrefValue = "";
			$this->Purchasing_Total_Amount->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Purchase_ID
			$this->Purchase_ID->EditAttrs["class"] = "form-control";
			$this->Purchase_ID->EditCustomAttributes = "";
			$this->Purchase_ID->EditValue = ew_HtmlEncode($this->Purchase_ID->AdvancedSearch->SearchValue);
			$this->Purchase_ID->PlaceHolder = ew_RemoveHtml($this->Purchase_ID->FldCaption());
			$this->Purchase_ID->EditAttrs["class"] = "form-control";
			$this->Purchase_ID->EditCustomAttributes = "";
			$this->Purchase_ID->EditValue2 = ew_HtmlEncode($this->Purchase_ID->AdvancedSearch->SearchValue2);
			$this->Purchase_ID->PlaceHolder = ew_RemoveHtml($this->Purchase_ID->FldCaption());

			// Purchase_Number
			$this->Purchase_Number->EditAttrs["class"] = "form-control";
			$this->Purchase_Number->EditCustomAttributes = "";
			$this->Purchase_Number->EditValue = ew_HtmlEncode($this->Purchase_Number->AdvancedSearch->SearchValue);
			$this->Purchase_Number->PlaceHolder = ew_RemoveHtml($this->Purchase_Number->FldCaption());
			$this->Purchase_Number->EditAttrs["class"] = "form-control";
			$this->Purchase_Number->EditCustomAttributes = "";
			$this->Purchase_Number->EditValue2 = ew_HtmlEncode($this->Purchase_Number->AdvancedSearch->SearchValue2);
			$this->Purchase_Number->PlaceHolder = ew_RemoveHtml($this->Purchase_Number->FldCaption());

			// Supplier_Number
			$this->Supplier_Number->EditAttrs["class"] = "form-control";
			$this->Supplier_Number->EditCustomAttributes = "";
			if (trim(strval($this->Supplier_Number->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier_Number->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
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
			$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Supplier_Number->EditValue = $arwrk;
			$this->Supplier_Number->EditAttrs["class"] = "form-control";
			$this->Supplier_Number->EditCustomAttributes = "";
			if (trim(strval($this->Supplier_Number->AdvancedSearch->SearchValue2)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier_Number->AdvancedSearch->SearchValue2, EW_DATATYPE_STRING, "");
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
			$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Supplier_Number->EditValue2 = $arwrk;

			// Stock_Item
			$this->Stock_Item->EditAttrs["class"] = "form-control";
			$this->Stock_Item->EditCustomAttributes = "";
			if (trim(strval($this->Stock_Item->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Stock_Number`" . ew_SearchString("=", $this->Stock_Item->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
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
			$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Stock_Item, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Stock_Item->EditValue = $arwrk;
			$this->Stock_Item->EditAttrs["class"] = "form-control";
			$this->Stock_Item->EditCustomAttributes = "";
			if (trim(strval($this->Stock_Item->AdvancedSearch->SearchValue2)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Stock_Number`" . ew_SearchString("=", $this->Stock_Item->AdvancedSearch->SearchValue2, EW_DATATYPE_STRING, "");
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
			$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Stock_Item, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Stock_Item->EditValue2 = $arwrk;

			// Purchasing_Quantity
			$this->Purchasing_Quantity->EditAttrs["class"] = "form-control";
			$this->Purchasing_Quantity->EditCustomAttributes = "";
			$this->Purchasing_Quantity->EditValue = ew_HtmlEncode($this->Purchasing_Quantity->AdvancedSearch->SearchValue);
			$this->Purchasing_Quantity->PlaceHolder = ew_RemoveHtml($this->Purchasing_Quantity->FldCaption());
			$this->Purchasing_Quantity->EditAttrs["class"] = "form-control";
			$this->Purchasing_Quantity->EditCustomAttributes = "";
			$this->Purchasing_Quantity->EditValue2 = ew_HtmlEncode($this->Purchasing_Quantity->AdvancedSearch->SearchValue2);
			$this->Purchasing_Quantity->PlaceHolder = ew_RemoveHtml($this->Purchasing_Quantity->FldCaption());

			// Purchasing_Price
			$this->Purchasing_Price->EditAttrs["class"] = "form-control";
			$this->Purchasing_Price->EditCustomAttributes = "";
			$this->Purchasing_Price->EditValue = ew_HtmlEncode($this->Purchasing_Price->AdvancedSearch->SearchValue);
			$this->Purchasing_Price->PlaceHolder = ew_RemoveHtml($this->Purchasing_Price->FldCaption());
			$this->Purchasing_Price->EditAttrs["class"] = "form-control";
			$this->Purchasing_Price->EditCustomAttributes = "";
			$this->Purchasing_Price->EditValue2 = ew_HtmlEncode($this->Purchasing_Price->AdvancedSearch->SearchValue2);
			$this->Purchasing_Price->PlaceHolder = ew_RemoveHtml($this->Purchasing_Price->FldCaption());

			// Selling_Price
			$this->Selling_Price->EditAttrs["class"] = "form-control";
			$this->Selling_Price->EditCustomAttributes = "";
			$this->Selling_Price->EditValue = ew_HtmlEncode($this->Selling_Price->AdvancedSearch->SearchValue);
			$this->Selling_Price->PlaceHolder = ew_RemoveHtml($this->Selling_Price->FldCaption());
			$this->Selling_Price->EditAttrs["class"] = "form-control";
			$this->Selling_Price->EditCustomAttributes = "";
			$this->Selling_Price->EditValue2 = ew_HtmlEncode($this->Selling_Price->AdvancedSearch->SearchValue2);
			$this->Selling_Price->PlaceHolder = ew_RemoveHtml($this->Selling_Price->FldCaption());

			// Purchasing_Total_Amount
			$this->Purchasing_Total_Amount->EditAttrs["class"] = "form-control";
			$this->Purchasing_Total_Amount->EditCustomAttributes = "";
			$this->Purchasing_Total_Amount->EditValue = ew_HtmlEncode($this->Purchasing_Total_Amount->AdvancedSearch->SearchValue);
			$this->Purchasing_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Purchasing_Total_Amount->FldCaption());
			$this->Purchasing_Total_Amount->EditAttrs["class"] = "form-control";
			$this->Purchasing_Total_Amount->EditCustomAttributes = "";
			$this->Purchasing_Total_Amount->EditValue2 = ew_HtmlEncode($this->Purchasing_Total_Amount->AdvancedSearch->SearchValue2);
			$this->Purchasing_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Purchasing_Total_Amount->FldCaption());
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
		if (!ew_CheckInteger($this->Purchase_ID->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Purchase_ID->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Purchase_ID->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Purchase_ID->FldErrMsg());
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
		$this->Purchase_ID->AdvancedSearch->Load();
		$this->Purchase_Number->AdvancedSearch->Load();
		$this->Supplier_Number->AdvancedSearch->Load();
		$this->Stock_Item->AdvancedSearch->Load();
		$this->Purchasing_Quantity->AdvancedSearch->Load();
		$this->Purchasing_Price->AdvancedSearch->Load();
		$this->Selling_Price->AdvancedSearch->Load();
		$this->Purchasing_Total_Amount->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("view_purchases_detailslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($view_purchases_details_search)) $view_purchases_details_search = new cview_purchases_details_search();

// Page init
$view_purchases_details_search->Page_Init();

// Page main
$view_purchases_details_search->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$view_purchases_details_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($view_purchases_details_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fview_purchases_detailssearch = new ew_Form("fview_purchases_detailssearch", "search");
<?php } else { ?>
var CurrentForm = fview_purchases_detailssearch = new ew_Form("fview_purchases_detailssearch", "search");
<?php } ?>

// Form_CustomValidate event
fview_purchases_detailssearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fview_purchases_detailssearch.ValidateRequired = true;
<?php } else { ?>
fview_purchases_detailssearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fview_purchases_detailssearch.Lists["x_Supplier_Number"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":["x_Stock_Item"],"FilterFields":[],"Options":[],"Template":""};
fview_purchases_detailssearch.Lists["x_Stock_Item"] = {"LinkField":"x_Stock_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Stock_Name","","",""],"ParentFields":["x_Supplier_Number"],"ChildFields":[],"FilterFields":["x_Supplier_Number"],"Options":[],"Template":""};

// Form object for search
// Validate function for search

fview_purchases_detailssearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Purchase_ID");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($view_purchases_details->Purchase_ID->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$view_purchases_details_search->IsModal) { ?>
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
<?php $view_purchases_details_search->ShowPageHeader(); ?>
<?php
$view_purchases_details_search->ShowMessage();
?>
<form name="fview_purchases_detailssearch" id="fview_purchases_detailssearch" class="<?php echo $view_purchases_details_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($view_purchases_details_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $view_purchases_details_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="view_purchases_details">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($view_purchases_details_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($view_purchases_details->Purchase_ID->Visible) { // Purchase_ID ?>
	<div id="r_Purchase_ID" class="form-group">
		<label for="x_Purchase_ID" class="<?php echo $view_purchases_details_search->SearchLabelClass ?>"><span id="elh_view_purchases_details_Purchase_ID"><?php echo $view_purchases_details->Purchase_ID->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $view_purchases_details_search->SearchRightColumnClass ?>"><div<?php echo $view_purchases_details->Purchase_ID->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Purchase_ID" id="z_Purchase_ID" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($view_purchases_details->Purchase_ID->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_view_purchases_details_Purchase_ID">
<input type="text" data-table="view_purchases_details" data-field="x_Purchase_ID" name="x_Purchase_ID" id="x_Purchase_ID" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchase_ID->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchase_ID->EditValue ?>"<?php echo $view_purchases_details->Purchase_ID->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Purchase_ID" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_view_purchases_details_Purchase_ID" class="btw1_Purchase_ID" style="display: none">
<input type="text" data-table="view_purchases_details" data-field="x_Purchase_ID" name="y_Purchase_ID" id="y_Purchase_ID" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchase_ID->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchase_ID->EditValue2 ?>"<?php echo $view_purchases_details->Purchase_ID->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($view_purchases_details->Purchase_Number->Visible) { // Purchase_Number ?>
	<div id="r_Purchase_Number" class="form-group">
		<label for="x_Purchase_Number" class="<?php echo $view_purchases_details_search->SearchLabelClass ?>"><span id="elh_view_purchases_details_Purchase_Number"><?php echo $view_purchases_details->Purchase_Number->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $view_purchases_details_search->SearchRightColumnClass ?>"><div<?php echo $view_purchases_details->Purchase_Number->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Purchase_Number" id="z_Purchase_Number" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($view_purchases_details->Purchase_Number->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_view_purchases_details_Purchase_Number">
<input type="text" data-table="view_purchases_details" data-field="x_Purchase_Number" name="x_Purchase_Number" id="x_Purchase_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchase_Number->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchase_Number->EditValue ?>"<?php echo $view_purchases_details->Purchase_Number->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Purchase_Number" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_view_purchases_details_Purchase_Number" class="btw1_Purchase_Number" style="display: none">
<input type="text" data-table="view_purchases_details" data-field="x_Purchase_Number" name="y_Purchase_Number" id="y_Purchase_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchase_Number->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchase_Number->EditValue2 ?>"<?php echo $view_purchases_details->Purchase_Number->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($view_purchases_details->Supplier_Number->Visible) { // Supplier_Number ?>
	<div id="r_Supplier_Number" class="form-group">
		<label for="x_Supplier_Number" class="<?php echo $view_purchases_details_search->SearchLabelClass ?>"><span id="elh_view_purchases_details_Supplier_Number"><?php echo $view_purchases_details->Supplier_Number->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $view_purchases_details_search->SearchRightColumnClass ?>"><div<?php echo $view_purchases_details->Supplier_Number->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Supplier_Number" id="z_Supplier_Number" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($view_purchases_details->Supplier_Number->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_view_purchases_details_Supplier_Number">
<?php $view_purchases_details->Supplier_Number->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$view_purchases_details->Supplier_Number->EditAttrs["onchange"]; ?>
<select data-table="view_purchases_details" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($view_purchases_details->Supplier_Number->DisplayValueSeparator) ? json_encode($view_purchases_details->Supplier_Number->DisplayValueSeparator) : $view_purchases_details->Supplier_Number->DisplayValueSeparator) ?>" id="x_Supplier_Number" name="x_Supplier_Number"<?php echo $view_purchases_details->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($view_purchases_details->Supplier_Number->EditValue)) {
	$arwrk = $view_purchases_details->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($view_purchases_details->Supplier_Number->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $view_purchases_details->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($view_purchases_details->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($view_purchases_details->Supplier_Number->CurrentValue) ?>" selected><?php echo $view_purchases_details->Supplier_Number->CurrentValue ?></option>
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
$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$view_purchases_details->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$view_purchases_details->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$view_purchases_details->Lookup_Selecting($view_purchases_details->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $view_purchases_details->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Supplier_Number" id="s_x_Supplier_Number" value="<?php echo $view_purchases_details->Supplier_Number->LookupFilterQuery() ?>">
</span>
			<span class="ewSearchCond btw1_Supplier_Number" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_view_purchases_details_Supplier_Number" class="btw1_Supplier_Number" style="display: none">
<select data-table="view_purchases_details" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($view_purchases_details->Supplier_Number->DisplayValueSeparator) ? json_encode($view_purchases_details->Supplier_Number->DisplayValueSeparator) : $view_purchases_details->Supplier_Number->DisplayValueSeparator) ?>" id="y_Supplier_Number" name="y_Supplier_Number"<?php echo $view_purchases_details->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($view_purchases_details->Supplier_Number->EditValue2)) {
	$arwrk = $view_purchases_details->Supplier_Number->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($view_purchases_details->Supplier_Number->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $view_purchases_details->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($view_purchases_details->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($view_purchases_details->Supplier_Number->CurrentValue) ?>" selected><?php echo $view_purchases_details->Supplier_Number->CurrentValue ?></option>
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
$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$view_purchases_details->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$view_purchases_details->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$view_purchases_details->Lookup_Selecting($view_purchases_details->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $view_purchases_details->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_y_Supplier_Number" id="s_y_Supplier_Number" value="<?php echo $view_purchases_details->Supplier_Number->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($view_purchases_details->Stock_Item->Visible) { // Stock_Item ?>
	<div id="r_Stock_Item" class="form-group">
		<label for="x_Stock_Item" class="<?php echo $view_purchases_details_search->SearchLabelClass ?>"><span id="elh_view_purchases_details_Stock_Item"><?php echo $view_purchases_details->Stock_Item->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $view_purchases_details_search->SearchRightColumnClass ?>"><div<?php echo $view_purchases_details->Stock_Item->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Stock_Item" id="z_Stock_Item" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($view_purchases_details->Stock_Item->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_view_purchases_details_Stock_Item">
<select data-table="view_purchases_details" data-field="x_Stock_Item" data-value-separator="<?php echo ew_HtmlEncode(is_array($view_purchases_details->Stock_Item->DisplayValueSeparator) ? json_encode($view_purchases_details->Stock_Item->DisplayValueSeparator) : $view_purchases_details->Stock_Item->DisplayValueSeparator) ?>" id="x_Stock_Item" name="x_Stock_Item"<?php echo $view_purchases_details->Stock_Item->EditAttributes() ?>>
<?php
if (is_array($view_purchases_details->Stock_Item->EditValue)) {
	$arwrk = $view_purchases_details->Stock_Item->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($view_purchases_details->Stock_Item->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $view_purchases_details->Stock_Item->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($view_purchases_details->Stock_Item->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($view_purchases_details->Stock_Item->CurrentValue) ?>" selected><?php echo $view_purchases_details->Stock_Item->CurrentValue ?></option>
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
$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$view_purchases_details->Stock_Item->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$view_purchases_details->Stock_Item->LookupFilters += array("f0" => "`Stock_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$view_purchases_details->Stock_Item->LookupFilters += array("f1" => "`Supplier_Number` IN ({filter_value})", "t1" => "200", "fn1" => "");
$sSqlWrk = "";
$view_purchases_details->Lookup_Selecting($view_purchases_details->Stock_Item, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $view_purchases_details->Stock_Item->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Stock_Item" id="s_x_Stock_Item" value="<?php echo $view_purchases_details->Stock_Item->LookupFilterQuery() ?>">
</span>
			<span class="ewSearchCond btw1_Stock_Item" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_view_purchases_details_Stock_Item" class="btw1_Stock_Item" style="display: none">
<select data-table="view_purchases_details" data-field="x_Stock_Item" data-value-separator="<?php echo ew_HtmlEncode(is_array($view_purchases_details->Stock_Item->DisplayValueSeparator) ? json_encode($view_purchases_details->Stock_Item->DisplayValueSeparator) : $view_purchases_details->Stock_Item->DisplayValueSeparator) ?>" id="y_Stock_Item" name="y_Stock_Item"<?php echo $view_purchases_details->Stock_Item->EditAttributes() ?>>
<?php
if (is_array($view_purchases_details->Stock_Item->EditValue2)) {
	$arwrk = $view_purchases_details->Stock_Item->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($view_purchases_details->Stock_Item->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $view_purchases_details->Stock_Item->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($view_purchases_details->Stock_Item->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($view_purchases_details->Stock_Item->CurrentValue) ?>" selected><?php echo $view_purchases_details->Stock_Item->CurrentValue ?></option>
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
$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$view_purchases_details->Stock_Item->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$view_purchases_details->Stock_Item->LookupFilters += array("f0" => "`Stock_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$view_purchases_details->Stock_Item->LookupFilters += array("f1" => "`Supplier_Number` IN ({filter_value})", "t1" => "200", "fn1" => "");
$sSqlWrk = "";
$view_purchases_details->Lookup_Selecting($view_purchases_details->Stock_Item, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $view_purchases_details->Stock_Item->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_y_Stock_Item" id="s_y_Stock_Item" value="<?php echo $view_purchases_details->Stock_Item->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($view_purchases_details->Purchasing_Quantity->Visible) { // Purchasing_Quantity ?>
	<div id="r_Purchasing_Quantity" class="form-group">
		<label for="x_Purchasing_Quantity" class="<?php echo $view_purchases_details_search->SearchLabelClass ?>"><span id="elh_view_purchases_details_Purchasing_Quantity"><?php echo $view_purchases_details->Purchasing_Quantity->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $view_purchases_details_search->SearchRightColumnClass ?>"><div<?php echo $view_purchases_details->Purchasing_Quantity->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Purchasing_Quantity" id="z_Purchasing_Quantity" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($view_purchases_details->Purchasing_Quantity->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($view_purchases_details->Purchasing_Quantity->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($view_purchases_details->Purchasing_Quantity->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($view_purchases_details->Purchasing_Quantity->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($view_purchases_details->Purchasing_Quantity->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($view_purchases_details->Purchasing_Quantity->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($view_purchases_details->Purchasing_Quantity->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_view_purchases_details_Purchasing_Quantity">
<input type="text" data-table="view_purchases_details" data-field="x_Purchasing_Quantity" name="x_Purchasing_Quantity" id="x_Purchasing_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchasing_Quantity->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchasing_Quantity->EditValue ?>"<?php echo $view_purchases_details->Purchasing_Quantity->EditAttributes() ?>>
<?php if (!$view_purchases_details->Purchasing_Quantity->ReadOnly && !$view_purchases_details->Purchasing_Quantity->Disabled && @$view_purchases_details->Purchasing_Quantity->EditAttrs["readonly"] == "" && @$view_purchases_details->Purchasing_Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Purchasing_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Purchasing_Quantity" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_view_purchases_details_Purchasing_Quantity" class="btw1_Purchasing_Quantity" style="display: none">
<input type="text" data-table="view_purchases_details" data-field="x_Purchasing_Quantity" name="y_Purchasing_Quantity" id="y_Purchasing_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchasing_Quantity->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchasing_Quantity->EditValue2 ?>"<?php echo $view_purchases_details->Purchasing_Quantity->EditAttributes() ?>>
<?php if (!$view_purchases_details->Purchasing_Quantity->ReadOnly && !$view_purchases_details->Purchasing_Quantity->Disabled && @$view_purchases_details->Purchasing_Quantity->EditAttrs["readonly"] == "" && @$view_purchases_details->Purchasing_Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Purchasing_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($view_purchases_details->Purchasing_Price->Visible) { // Purchasing_Price ?>
	<div id="r_Purchasing_Price" class="form-group">
		<label for="x_Purchasing_Price" class="<?php echo $view_purchases_details_search->SearchLabelClass ?>"><span id="elh_view_purchases_details_Purchasing_Price"><?php echo $view_purchases_details->Purchasing_Price->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $view_purchases_details_search->SearchRightColumnClass ?>"><div<?php echo $view_purchases_details->Purchasing_Price->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Purchasing_Price" id="z_Purchasing_Price" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($view_purchases_details->Purchasing_Price->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($view_purchases_details->Purchasing_Price->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($view_purchases_details->Purchasing_Price->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($view_purchases_details->Purchasing_Price->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($view_purchases_details->Purchasing_Price->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($view_purchases_details->Purchasing_Price->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($view_purchases_details->Purchasing_Price->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_view_purchases_details_Purchasing_Price">
<input type="text" data-table="view_purchases_details" data-field="x_Purchasing_Price" name="x_Purchasing_Price" id="x_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchasing_Price->EditValue ?>"<?php echo $view_purchases_details->Purchasing_Price->EditAttributes() ?>>
<?php if (!$view_purchases_details->Purchasing_Price->ReadOnly && !$view_purchases_details->Purchasing_Price->Disabled && @$view_purchases_details->Purchasing_Price->EditAttrs["readonly"] == "" && @$view_purchases_details->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Purchasing_Price" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_view_purchases_details_Purchasing_Price" class="btw1_Purchasing_Price" style="display: none">
<input type="text" data-table="view_purchases_details" data-field="x_Purchasing_Price" name="y_Purchasing_Price" id="y_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchasing_Price->EditValue2 ?>"<?php echo $view_purchases_details->Purchasing_Price->EditAttributes() ?>>
<?php if (!$view_purchases_details->Purchasing_Price->ReadOnly && !$view_purchases_details->Purchasing_Price->Disabled && @$view_purchases_details->Purchasing_Price->EditAttrs["readonly"] == "" && @$view_purchases_details->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($view_purchases_details->Selling_Price->Visible) { // Selling_Price ?>
	<div id="r_Selling_Price" class="form-group">
		<label for="x_Selling_Price" class="<?php echo $view_purchases_details_search->SearchLabelClass ?>"><span id="elh_view_purchases_details_Selling_Price"><?php echo $view_purchases_details->Selling_Price->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $view_purchases_details_search->SearchRightColumnClass ?>"><div<?php echo $view_purchases_details->Selling_Price->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Selling_Price" id="z_Selling_Price" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($view_purchases_details->Selling_Price->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($view_purchases_details->Selling_Price->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($view_purchases_details->Selling_Price->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($view_purchases_details->Selling_Price->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($view_purchases_details->Selling_Price->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($view_purchases_details->Selling_Price->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($view_purchases_details->Selling_Price->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_view_purchases_details_Selling_Price">
<input type="text" data-table="view_purchases_details" data-field="x_Selling_Price" name="x_Selling_Price" id="x_Selling_Price" size="30" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Selling_Price->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Selling_Price->EditValue ?>"<?php echo $view_purchases_details->Selling_Price->EditAttributes() ?>>
<?php if (!$view_purchases_details->Selling_Price->ReadOnly && !$view_purchases_details->Selling_Price->Disabled && @$view_purchases_details->Selling_Price->EditAttrs["readonly"] == "" && @$view_purchases_details->Selling_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Selling_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Selling_Price" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_view_purchases_details_Selling_Price" class="btw1_Selling_Price" style="display: none">
<input type="text" data-table="view_purchases_details" data-field="x_Selling_Price" name="y_Selling_Price" id="y_Selling_Price" size="30" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Selling_Price->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Selling_Price->EditValue2 ?>"<?php echo $view_purchases_details->Selling_Price->EditAttributes() ?>>
<?php if (!$view_purchases_details->Selling_Price->ReadOnly && !$view_purchases_details->Selling_Price->Disabled && @$view_purchases_details->Selling_Price->EditAttrs["readonly"] == "" && @$view_purchases_details->Selling_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Selling_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($view_purchases_details->Purchasing_Total_Amount->Visible) { // Purchasing_Total_Amount ?>
	<div id="r_Purchasing_Total_Amount" class="form-group">
		<label for="x_Purchasing_Total_Amount" class="<?php echo $view_purchases_details_search->SearchLabelClass ?>"><span id="elh_view_purchases_details_Purchasing_Total_Amount"><?php echo $view_purchases_details->Purchasing_Total_Amount->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $view_purchases_details_search->SearchRightColumnClass ?>"><div<?php echo $view_purchases_details->Purchasing_Total_Amount->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Purchasing_Total_Amount" id="z_Purchasing_Total_Amount" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($view_purchases_details->Purchasing_Total_Amount->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($view_purchases_details->Purchasing_Total_Amount->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($view_purchases_details->Purchasing_Total_Amount->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($view_purchases_details->Purchasing_Total_Amount->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($view_purchases_details->Purchasing_Total_Amount->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($view_purchases_details->Purchasing_Total_Amount->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($view_purchases_details->Purchasing_Total_Amount->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_view_purchases_details_Purchasing_Total_Amount">
<input type="text" data-table="view_purchases_details" data-field="x_Purchasing_Total_Amount" name="x_Purchasing_Total_Amount" id="x_Purchasing_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchasing_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchasing_Total_Amount->EditValue ?>"<?php echo $view_purchases_details->Purchasing_Total_Amount->EditAttributes() ?>>
<?php if (!$view_purchases_details->Purchasing_Total_Amount->ReadOnly && !$view_purchases_details->Purchasing_Total_Amount->Disabled && @$view_purchases_details->Purchasing_Total_Amount->EditAttrs["readonly"] == "" && @$view_purchases_details->Purchasing_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Purchasing_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Purchasing_Total_Amount" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_view_purchases_details_Purchasing_Total_Amount" class="btw1_Purchasing_Total_Amount" style="display: none">
<input type="text" data-table="view_purchases_details" data-field="x_Purchasing_Total_Amount" name="y_Purchasing_Total_Amount" id="y_Purchasing_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($view_purchases_details->Purchasing_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $view_purchases_details->Purchasing_Total_Amount->EditValue2 ?>"<?php echo $view_purchases_details->Purchasing_Total_Amount->EditAttributes() ?>>
<?php if (!$view_purchases_details->Purchasing_Total_Amount->ReadOnly && !$view_purchases_details->Purchasing_Total_Amount->Disabled && @$view_purchases_details->Purchasing_Total_Amount->EditAttrs["readonly"] == "" && @$view_purchases_details->Purchasing_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Purchasing_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$view_purchases_details_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fview_purchases_detailssearch.Init();
</script>
<?php
$view_purchases_details_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fview_purchases_detailssearch:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$view_purchases_details_search->Page_Terminate();
?>
