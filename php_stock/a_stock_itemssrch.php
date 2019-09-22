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
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_stock_items_search = NULL; // Initialize page object first

class ca_stock_items_search extends ca_stock_items {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_stock_items';

	// Page object name
	var $PageObjName = 'a_stock_items_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
		if (!$Security->CanSearch()) {
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
						$sSrchStr = "a_stock_itemslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Stock_ID); // Stock_ID
		$this->BuildSearchUrl($sSrchUrl, $this->Category); // Category
		$this->BuildSearchUrl($sSrchUrl, $this->Supplier_Number); // Supplier_Number
		$this->BuildSearchUrl($sSrchUrl, $this->Stock_Number); // Stock_Number
		$this->BuildSearchUrl($sSrchUrl, $this->Stock_Name); // Stock_Name
		$this->BuildSearchUrl($sSrchUrl, $this->Unit_Of_Measurement); // Unit_Of_Measurement
		$this->BuildSearchUrl($sSrchUrl, $this->Purchasing_Price); // Purchasing_Price
		$this->BuildSearchUrl($sSrchUrl, $this->Selling_Price); // Selling_Price
		$this->BuildSearchUrl($sSrchUrl, $this->Quantity); // Quantity
		$this->BuildSearchUrl($sSrchUrl, $this->Notes); // Notes
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
		// Stock_ID

		$this->Stock_ID->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Stock_ID"));
		$this->Stock_ID->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Stock_ID");
		$this->Stock_ID->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Stock_ID");
		$this->Stock_ID->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Stock_ID"));
		$this->Stock_ID->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Stock_ID");

		// Category
		$this->Category->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Category"));
		$this->Category->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Category");
		$this->Category->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Category");
		$this->Category->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Category"));
		$this->Category->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Category");

		// Supplier_Number
		$this->Supplier_Number->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Supplier_Number"));
		$this->Supplier_Number->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Supplier_Number");
		$this->Supplier_Number->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Supplier_Number");
		$this->Supplier_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Supplier_Number"));
		$this->Supplier_Number->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Supplier_Number");

		// Stock_Number
		$this->Stock_Number->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Stock_Number"));
		$this->Stock_Number->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Stock_Number");
		$this->Stock_Number->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Stock_Number");
		$this->Stock_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Stock_Number"));
		$this->Stock_Number->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Stock_Number");

		// Stock_Name
		$this->Stock_Name->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Stock_Name"));
		$this->Stock_Name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Stock_Name");
		$this->Stock_Name->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Stock_Name");
		$this->Stock_Name->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Stock_Name"));
		$this->Stock_Name->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Stock_Name");

		// Unit_Of_Measurement
		$this->Unit_Of_Measurement->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Unit_Of_Measurement"));
		$this->Unit_Of_Measurement->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Unit_Of_Measurement");
		$this->Unit_Of_Measurement->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Unit_Of_Measurement");
		$this->Unit_Of_Measurement->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Unit_Of_Measurement"));
		$this->Unit_Of_Measurement->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Unit_Of_Measurement");

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

		// Quantity
		$this->Quantity->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Quantity"));
		$this->Quantity->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Quantity");
		$this->Quantity->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Quantity");
		$this->Quantity->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Quantity"));
		$this->Quantity->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Quantity");

		// Notes
		$this->Notes->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Notes"));
		$this->Notes->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Notes");
		$this->Notes->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Notes");
		$this->Notes->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Notes"));
		$this->Notes->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Notes");

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Stock_ID
			$this->Stock_ID->EditAttrs["class"] = "form-control";
			$this->Stock_ID->EditCustomAttributes = "";
			$this->Stock_ID->EditValue = ew_HtmlEncode($this->Stock_ID->AdvancedSearch->SearchValue);
			$this->Stock_ID->PlaceHolder = ew_RemoveHtml($this->Stock_ID->FldCaption());
			$this->Stock_ID->EditAttrs["class"] = "form-control";
			$this->Stock_ID->EditCustomAttributes = "";
			$this->Stock_ID->EditValue2 = ew_HtmlEncode($this->Stock_ID->AdvancedSearch->SearchValue2);
			$this->Stock_ID->PlaceHolder = ew_RemoveHtml($this->Stock_ID->FldCaption());

			// Category
			$this->Category->EditAttrs["class"] = "form-control";
			$this->Category->EditCustomAttributes = "";
			if (trim(strval($this->Category->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Category_ID`" . ew_SearchString("=", $this->Category->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
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
			$this->Category->EditAttrs["class"] = "form-control";
			$this->Category->EditCustomAttributes = "";
			if (trim(strval($this->Category->AdvancedSearch->SearchValue2)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Category_ID`" . ew_SearchString("=", $this->Category->AdvancedSearch->SearchValue2, EW_DATATYPE_NUMBER, "");
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
			$this->Category->EditValue2 = $arwrk;

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
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Supplier_Name`";
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
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Supplier_Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Supplier_Number->EditValue2 = $arwrk;

			// Stock_Number
			$this->Stock_Number->EditAttrs["class"] = "form-control";
			$this->Stock_Number->EditCustomAttributes = "";
			$this->Stock_Number->EditValue = ew_HtmlEncode($this->Stock_Number->AdvancedSearch->SearchValue);
			$this->Stock_Number->PlaceHolder = ew_RemoveHtml($this->Stock_Number->FldCaption());
			$this->Stock_Number->EditAttrs["class"] = "form-control";
			$this->Stock_Number->EditCustomAttributes = "";
			$this->Stock_Number->EditValue2 = ew_HtmlEncode($this->Stock_Number->AdvancedSearch->SearchValue2);
			$this->Stock_Number->PlaceHolder = ew_RemoveHtml($this->Stock_Number->FldCaption());

			// Stock_Name
			$this->Stock_Name->EditAttrs["class"] = "form-control";
			$this->Stock_Name->EditCustomAttributes = "";
			$this->Stock_Name->EditValue = ew_HtmlEncode($this->Stock_Name->AdvancedSearch->SearchValue);
			$this->Stock_Name->PlaceHolder = ew_RemoveHtml($this->Stock_Name->FldCaption());
			$this->Stock_Name->EditAttrs["class"] = "form-control";
			$this->Stock_Name->EditCustomAttributes = "";
			$this->Stock_Name->EditValue2 = ew_HtmlEncode($this->Stock_Name->AdvancedSearch->SearchValue2);
			$this->Stock_Name->PlaceHolder = ew_RemoveHtml($this->Stock_Name->FldCaption());

			// Unit_Of_Measurement
			$this->Unit_Of_Measurement->EditAttrs["class"] = "form-control";
			$this->Unit_Of_Measurement->EditCustomAttributes = "";
			if (trim(strval($this->Unit_Of_Measurement->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`UOM_ID`" . ew_SearchString("=", $this->Unit_Of_Measurement->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
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
			$this->Unit_Of_Measurement->EditAttrs["class"] = "form-control";
			$this->Unit_Of_Measurement->EditCustomAttributes = "";
			if (trim(strval($this->Unit_Of_Measurement->AdvancedSearch->SearchValue2)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`UOM_ID`" . ew_SearchString("=", $this->Unit_Of_Measurement->AdvancedSearch->SearchValue2, EW_DATATYPE_STRING, "");
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
			$this->Unit_Of_Measurement->EditValue2 = $arwrk;

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

			// Quantity
			$this->Quantity->EditAttrs["class"] = "form-control";
			$this->Quantity->EditCustomAttributes = "";
			$this->Quantity->EditValue = ew_HtmlEncode($this->Quantity->AdvancedSearch->SearchValue);
			$this->Quantity->PlaceHolder = ew_RemoveHtml($this->Quantity->FldCaption());
			$this->Quantity->EditAttrs["class"] = "form-control";
			$this->Quantity->EditCustomAttributes = "";
			$this->Quantity->EditValue2 = ew_HtmlEncode($this->Quantity->AdvancedSearch->SearchValue2);
			$this->Quantity->PlaceHolder = ew_RemoveHtml($this->Quantity->FldCaption());

			// Notes
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue = ew_HtmlEncode($this->Notes->AdvancedSearch->SearchValue);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue2 = ew_HtmlEncode($this->Notes->AdvancedSearch->SearchValue2);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

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
		if (!ew_CheckInteger($this->Stock_ID->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Stock_ID->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Stock_ID->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Stock_ID->FldErrMsg());
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
		$this->Stock_ID->AdvancedSearch->Load();
		$this->Category->AdvancedSearch->Load();
		$this->Supplier_Number->AdvancedSearch->Load();
		$this->Stock_Number->AdvancedSearch->Load();
		$this->Stock_Name->AdvancedSearch->Load();
		$this->Unit_Of_Measurement->AdvancedSearch->Load();
		$this->Purchasing_Price->AdvancedSearch->Load();
		$this->Selling_Price->AdvancedSearch->Load();
		$this->Quantity->AdvancedSearch->Load();
		$this->Notes->AdvancedSearch->Load();
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_stock_itemslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($a_stock_items_search)) $a_stock_items_search = new ca_stock_items_search();

// Page init
$a_stock_items_search->Page_Init();

// Page main
$a_stock_items_search->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_stock_items_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($a_stock_items_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fa_stock_itemssearch = new ew_Form("fa_stock_itemssearch", "search");
<?php } else { ?>
var CurrentForm = fa_stock_itemssearch = new ew_Form("fa_stock_itemssearch", "search");
<?php } ?>

// Form_CustomValidate event
fa_stock_itemssearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_stock_itemssearch.ValidateRequired = true;
<?php } else { ?>
fa_stock_itemssearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_stock_itemssearch.Lists["x_Category"] = {"LinkField":"x_Category_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Category_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_stock_itemssearch.Lists["x_Supplier_Number"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_stock_itemssearch.Lists["x_Unit_Of_Measurement"] = {"LinkField":"x_UOM_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_UOM_Description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
// Validate function for search

fa_stock_itemssearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Stock_ID");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($a_stock_items->Stock_ID->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$a_stock_items_search->IsModal) { ?>
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
<?php $a_stock_items_search->ShowPageHeader(); ?>
<?php
$a_stock_items_search->ShowMessage();
?>
<form name="fa_stock_itemssearch" id="fa_stock_itemssearch" class="<?php echo $a_stock_items_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_stock_items_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_stock_items_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_stock_items">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($a_stock_items_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($a_stock_items->Stock_ID->Visible) { // Stock_ID ?>
	<div id="r_Stock_ID" class="form-group">
		<label for="x_Stock_ID" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Stock_ID"><?php echo $a_stock_items->Stock_ID->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Stock_ID->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Stock_ID" id="z_Stock_ID" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Stock_ID->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Stock_ID">
<input type="text" data-table="a_stock_items" data-field="x_Stock_ID" name="x_Stock_ID" id="x_Stock_ID" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_ID->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_ID->EditValue ?>"<?php echo $a_stock_items->Stock_ID->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Stock_ID" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Stock_ID" class="btw1_Stock_ID" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Stock_ID" name="y_Stock_ID" id="y_Stock_ID" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_ID->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_ID->EditValue2 ?>"<?php echo $a_stock_items->Stock_ID->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Category->Visible) { // Category ?>
	<div id="r_Category" class="form-group">
		<label for="x_Category" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Category"><?php echo $a_stock_items->Category->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Category->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Category" id="z_Category" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Category->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Category->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Category->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Category->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Category->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Category->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Category->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Category">
<select data-table="a_stock_items" data-field="x_Category" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Category->DisplayValueSeparator) ? json_encode($a_stock_items->Category->DisplayValueSeparator) : $a_stock_items->Category->DisplayValueSeparator) ?>" id="x_Category" name="x_Category"<?php echo $a_stock_items->Category->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Category->EditValue)) {
	$arwrk = $a_stock_items->Category->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Category->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
			<span class="ewSearchCond btw1_Category" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Category" class="btw1_Category" style="display: none">
<select data-table="a_stock_items" data-field="x_Category" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Category->DisplayValueSeparator) ? json_encode($a_stock_items->Category->DisplayValueSeparator) : $a_stock_items->Category->DisplayValueSeparator) ?>" id="y_Category" name="y_Category"<?php echo $a_stock_items->Category->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Category->EditValue2)) {
	$arwrk = $a_stock_items->Category->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Category->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
<input type="hidden" name="s_y_Category" id="s_y_Category" value="<?php echo $a_stock_items->Category->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Supplier_Number->Visible) { // Supplier_Number ?>
	<div id="r_Supplier_Number" class="form-group">
		<label for="x_Supplier_Number" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Supplier_Number"><?php echo $a_stock_items->Supplier_Number->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Supplier_Number->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Supplier_Number" id="z_Supplier_Number" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Supplier_Number->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Supplier_Number">
<select data-table="a_stock_items" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Supplier_Number->DisplayValueSeparator) ? json_encode($a_stock_items->Supplier_Number->DisplayValueSeparator) : $a_stock_items->Supplier_Number->DisplayValueSeparator) ?>" id="x_Supplier_Number" name="x_Supplier_Number"<?php echo $a_stock_items->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Supplier_Number->EditValue)) {
	$arwrk = $a_stock_items->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Supplier_Number->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
			<span class="ewSearchCond btw1_Supplier_Number" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Supplier_Number" class="btw1_Supplier_Number" style="display: none">
<select data-table="a_stock_items" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Supplier_Number->DisplayValueSeparator) ? json_encode($a_stock_items->Supplier_Number->DisplayValueSeparator) : $a_stock_items->Supplier_Number->DisplayValueSeparator) ?>" id="y_Supplier_Number" name="y_Supplier_Number"<?php echo $a_stock_items->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Supplier_Number->EditValue2)) {
	$arwrk = $a_stock_items->Supplier_Number->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Supplier_Number->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
<input type="hidden" name="s_y_Supplier_Number" id="s_y_Supplier_Number" value="<?php echo $a_stock_items->Supplier_Number->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Stock_Number->Visible) { // Stock_Number ?>
	<div id="r_Stock_Number" class="form-group">
		<label for="x_Stock_Number" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Stock_Number"><?php echo $a_stock_items->Stock_Number->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Stock_Number->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Stock_Number" id="z_Stock_Number" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Stock_Number->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Stock_Number">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Number" name="x_Stock_Number" id="x_Stock_Number" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Number->EditValue ?>"<?php echo $a_stock_items->Stock_Number->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Stock_Number" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Stock_Number" class="btw1_Stock_Number" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Number" name="y_Stock_Number" id="y_Stock_Number" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Number->EditValue2 ?>"<?php echo $a_stock_items->Stock_Number->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Stock_Name->Visible) { // Stock_Name ?>
	<div id="r_Stock_Name" class="form-group">
		<label for="x_Stock_Name" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Stock_Name"><?php echo $a_stock_items->Stock_Name->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Stock_Name->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Stock_Name" id="z_Stock_Name" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Stock_Name->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Stock_Name">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Name" name="x_Stock_Name" id="x_Stock_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Name->EditValue ?>"<?php echo $a_stock_items->Stock_Name->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Stock_Name" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Stock_Name" class="btw1_Stock_Name" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Name" name="y_Stock_Name" id="y_Stock_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Name->EditValue2 ?>"<?php echo $a_stock_items->Stock_Name->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Unit_Of_Measurement->Visible) { // Unit_Of_Measurement ?>
	<div id="r_Unit_Of_Measurement" class="form-group">
		<label for="x_Unit_Of_Measurement" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Unit_Of_Measurement"><?php echo $a_stock_items->Unit_Of_Measurement->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Unit_Of_Measurement->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Unit_Of_Measurement" id="z_Unit_Of_Measurement" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Unit_Of_Measurement">
<select data-table="a_stock_items" data-field="x_Unit_Of_Measurement" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) ? json_encode($a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) : $a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) ?>" id="x_Unit_Of_Measurement" name="x_Unit_Of_Measurement"<?php echo $a_stock_items->Unit_Of_Measurement->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Unit_Of_Measurement->EditValue)) {
	$arwrk = $a_stock_items->Unit_Of_Measurement->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
			<span class="ewSearchCond btw1_Unit_Of_Measurement" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Unit_Of_Measurement" class="btw1_Unit_Of_Measurement" style="display: none">
<select data-table="a_stock_items" data-field="x_Unit_Of_Measurement" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) ? json_encode($a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) : $a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) ?>" id="y_Unit_Of_Measurement" name="y_Unit_Of_Measurement"<?php echo $a_stock_items->Unit_Of_Measurement->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Unit_Of_Measurement->EditValue2)) {
	$arwrk = $a_stock_items->Unit_Of_Measurement->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Unit_Of_Measurement->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
<input type="hidden" name="s_y_Unit_Of_Measurement" id="s_y_Unit_Of_Measurement" value="<?php echo $a_stock_items->Unit_Of_Measurement->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Purchasing_Price->Visible) { // Purchasing_Price ?>
	<div id="r_Purchasing_Price" class="form-group">
		<label for="x_Purchasing_Price" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Purchasing_Price"><?php echo $a_stock_items->Purchasing_Price->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Purchasing_Price->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Purchasing_Price" id="z_Purchasing_Price" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Purchasing_Price->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Purchasing_Price->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Purchasing_Price->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Purchasing_Price->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Purchasing_Price->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Purchasing_Price->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Purchasing_Price->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Purchasing_Price">
<input type="text" data-table="a_stock_items" data-field="x_Purchasing_Price" name="x_Purchasing_Price" id="x_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Purchasing_Price->EditValue ?>"<?php echo $a_stock_items->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Purchasing_Price->ReadOnly && !$a_stock_items->Purchasing_Price->Disabled && @$a_stock_items->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Purchasing_Price" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Purchasing_Price" class="btw1_Purchasing_Price" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Purchasing_Price" name="y_Purchasing_Price" id="y_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Purchasing_Price->EditValue2 ?>"<?php echo $a_stock_items->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Purchasing_Price->ReadOnly && !$a_stock_items->Purchasing_Price->Disabled && @$a_stock_items->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Selling_Price->Visible) { // Selling_Price ?>
	<div id="r_Selling_Price" class="form-group">
		<label for="x_Selling_Price" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Selling_Price"><?php echo $a_stock_items->Selling_Price->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Selling_Price->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Selling_Price" id="z_Selling_Price" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Selling_Price->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Selling_Price->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Selling_Price->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Selling_Price->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Selling_Price->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Selling_Price->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Selling_Price->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Selling_Price">
<input type="text" data-table="a_stock_items" data-field="x_Selling_Price" name="x_Selling_Price" id="x_Selling_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Selling_Price->EditValue ?>"<?php echo $a_stock_items->Selling_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Selling_Price->ReadOnly && !$a_stock_items->Selling_Price->Disabled && @$a_stock_items->Selling_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Selling_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Selling_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Selling_Price" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Selling_Price" class="btw1_Selling_Price" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Selling_Price" name="y_Selling_Price" id="y_Selling_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Selling_Price->EditValue2 ?>"<?php echo $a_stock_items->Selling_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Selling_Price->ReadOnly && !$a_stock_items->Selling_Price->Disabled && @$a_stock_items->Selling_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Selling_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Selling_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Quantity->Visible) { // Quantity ?>
	<div id="r_Quantity" class="form-group">
		<label for="x_Quantity" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Quantity"><?php echo $a_stock_items->Quantity->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Quantity->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Quantity" id="z_Quantity" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Quantity->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Quantity->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Quantity->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Quantity->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Quantity->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Quantity->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Quantity->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Quantity">
<input type="text" data-table="a_stock_items" data-field="x_Quantity" name="x_Quantity" id="x_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Quantity->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Quantity->EditValue ?>"<?php echo $a_stock_items->Quantity->EditAttributes() ?>>
<?php if (!$a_stock_items->Quantity->ReadOnly && !$a_stock_items->Quantity->Disabled && @$a_stock_items->Quantity->EditAttrs["readonly"] == "" && @$a_stock_items->Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Quantity" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Quantity" class="btw1_Quantity" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Quantity" name="y_Quantity" id="y_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Quantity->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Quantity->EditValue2 ?>"<?php echo $a_stock_items->Quantity->EditAttributes() ?>>
<?php if (!$a_stock_items->Quantity->ReadOnly && !$a_stock_items->Quantity->Disabled && @$a_stock_items->Quantity->EditAttrs["readonly"] == "" && @$a_stock_items->Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Notes->Visible) { // Notes ?>
	<div id="r_Notes" class="form-group">
		<label for="x_Notes" class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Notes"><?php echo $a_stock_items->Notes->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Notes->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Notes" id="z_Notes" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Notes->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Notes">
<input type="text" data-table="a_stock_items" data-field="x_Notes" name="x_Notes" id="x_Notes" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Notes->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Notes->EditValue ?>"<?php echo $a_stock_items->Notes->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Notes" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Notes" class="btw1_Notes" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Notes" name="y_Notes" id="y_Notes" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Notes->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Notes->EditValue2 ?>"<?php echo $a_stock_items->Notes->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Date_Added->Visible) { // Date_Added ?>
	<div id="r_Date_Added" class="form-group">
		<label class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Date_Added"><?php echo $a_stock_items->Date_Added->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Date_Added->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Added" id="z_Date_Added" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Date_Added->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Date_Added">
<input type="text" data-table="a_stock_items" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Date_Added->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Date_Added->EditValue ?>"<?php echo $a_stock_items->Date_Added->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Date_Added" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Date_Added" class="btw1_Date_Added" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Date_Added" name="y_Date_Added" id="y_Date_Added" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Date_Added->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Date_Added->EditValue2 ?>"<?php echo $a_stock_items->Date_Added->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Added_By->Visible) { // Added_By ?>
	<div id="r_Added_By" class="form-group">
		<label class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Added_By"><?php echo $a_stock_items->Added_By->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Added_By->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Added_By" id="z_Added_By" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Added_By->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Added_By">
<input type="text" data-table="a_stock_items" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Added_By->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Added_By->EditValue ?>"<?php echo $a_stock_items->Added_By->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Added_By" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Added_By" class="btw1_Added_By" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Added_By" name="y_Added_By" id="y_Added_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Added_By->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Added_By->EditValue2 ?>"<?php echo $a_stock_items->Added_By->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Date_Updated->Visible) { // Date_Updated ?>
	<div id="r_Date_Updated" class="form-group">
		<label class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Date_Updated"><?php echo $a_stock_items->Date_Updated->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Date_Updated->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Updated" id="z_Date_Updated" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Date_Updated->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Date_Updated">
<input type="text" data-table="a_stock_items" data-field="x_Date_Updated" name="x_Date_Updated" id="x_Date_Updated" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Date_Updated->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Date_Updated->EditValue ?>"<?php echo $a_stock_items->Date_Updated->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Date_Updated" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Date_Updated" class="btw1_Date_Updated" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Date_Updated" name="y_Date_Updated" id="y_Date_Updated" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Date_Updated->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Date_Updated->EditValue2 ?>"<?php echo $a_stock_items->Date_Updated->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Updated_By->Visible) { // Updated_By ?>
	<div id="r_Updated_By" class="form-group">
		<label class="<?php echo $a_stock_items_search->SearchLabelClass ?>"><span id="elh_a_stock_items_Updated_By"><?php echo $a_stock_items->Updated_By->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_stock_items_search->SearchRightColumnClass ?>"><div<?php echo $a_stock_items->Updated_By->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Updated_By" id="z_Updated_By" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_stock_items->Updated_By->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_stock_items_Updated_By">
<input type="text" data-table="a_stock_items" data-field="x_Updated_By" name="x_Updated_By" id="x_Updated_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Updated_By->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Updated_By->EditValue ?>"<?php echo $a_stock_items->Updated_By->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Updated_By" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_stock_items_Updated_By" class="btw1_Updated_By" style="display: none">
<input type="text" data-table="a_stock_items" data-field="x_Updated_By" name="y_Updated_By" id="y_Updated_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Updated_By->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Updated_By->EditValue2 ?>"<?php echo $a_stock_items->Updated_By->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$a_stock_items_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fa_stock_itemssearch.Init();
</script>
<?php
$a_stock_items_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_stock_itemssearch:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_stock_items_search->Page_Terminate();
?>
