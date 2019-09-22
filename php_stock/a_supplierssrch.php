<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "a_suppliersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_suppliers_search = NULL; // Initialize page object first

class ca_suppliers_search extends ca_suppliers {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_suppliers';

	// Page object name
	var $PageObjName = 'a_suppliers_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
		if (!$Security->CanSearch()) {
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
		$this->Supplier_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
						$sSrchStr = "a_supplierslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Supplier_ID); // Supplier_ID
		$this->BuildSearchUrl($sSrchUrl, $this->Supplier_Number); // Supplier_Number
		$this->BuildSearchUrl($sSrchUrl, $this->Supplier_Name); // Supplier_Name
		$this->BuildSearchUrl($sSrchUrl, $this->Address); // Address
		$this->BuildSearchUrl($sSrchUrl, $this->City); // City
		$this->BuildSearchUrl($sSrchUrl, $this->Country); // Country
		$this->BuildSearchUrl($sSrchUrl, $this->Contact_Person); // Contact_Person
		$this->BuildSearchUrl($sSrchUrl, $this->Phone_Number); // Phone_Number
		$this->BuildSearchUrl($sSrchUrl, $this->_Email); // Email
		$this->BuildSearchUrl($sSrchUrl, $this->Mobile_Number); // Mobile_Number
		$this->BuildSearchUrl($sSrchUrl, $this->Notes); // Notes
		$this->BuildSearchUrl($sSrchUrl, $this->Balance); // Balance
		$this->BuildSearchUrl($sSrchUrl, $this->Is_Stock_Available); // Is_Stock_Available
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
		// Supplier_ID

		$this->Supplier_ID->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Supplier_ID"));
		$this->Supplier_ID->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Supplier_ID");
		$this->Supplier_ID->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Supplier_ID");
		$this->Supplier_ID->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Supplier_ID"));
		$this->Supplier_ID->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Supplier_ID");

		// Supplier_Number
		$this->Supplier_Number->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Supplier_Number"));
		$this->Supplier_Number->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Supplier_Number");
		$this->Supplier_Number->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Supplier_Number");
		$this->Supplier_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Supplier_Number"));
		$this->Supplier_Number->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Supplier_Number");

		// Supplier_Name
		$this->Supplier_Name->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Supplier_Name"));
		$this->Supplier_Name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Supplier_Name");
		$this->Supplier_Name->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Supplier_Name");
		$this->Supplier_Name->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Supplier_Name"));
		$this->Supplier_Name->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Supplier_Name");

		// Address
		$this->Address->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Address"));
		$this->Address->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Address");
		$this->Address->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Address");
		$this->Address->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Address"));
		$this->Address->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Address");

		// City
		$this->City->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_City"));
		$this->City->AdvancedSearch->SearchOperator = $objForm->GetValue("z_City");
		$this->City->AdvancedSearch->SearchCondition = $objForm->GetValue("v_City");
		$this->City->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_City"));
		$this->City->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_City");

		// Country
		$this->Country->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Country"));
		$this->Country->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Country");
		$this->Country->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Country");
		$this->Country->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Country"));
		$this->Country->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Country");

		// Contact_Person
		$this->Contact_Person->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Contact_Person"));
		$this->Contact_Person->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Contact_Person");
		$this->Contact_Person->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Contact_Person");
		$this->Contact_Person->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Contact_Person"));
		$this->Contact_Person->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Contact_Person");

		// Phone_Number
		$this->Phone_Number->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Phone_Number"));
		$this->Phone_Number->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Phone_Number");
		$this->Phone_Number->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Phone_Number");
		$this->Phone_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Phone_Number"));
		$this->Phone_Number->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Phone_Number");

		// Email
		$this->_Email->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x__Email"));
		$this->_Email->AdvancedSearch->SearchOperator = $objForm->GetValue("z__Email");
		$this->_Email->AdvancedSearch->SearchCondition = $objForm->GetValue("v__Email");
		$this->_Email->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y__Email"));
		$this->_Email->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w__Email");

		// Mobile_Number
		$this->Mobile_Number->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Mobile_Number"));
		$this->Mobile_Number->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Mobile_Number");
		$this->Mobile_Number->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Mobile_Number");
		$this->Mobile_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Mobile_Number"));
		$this->Mobile_Number->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Mobile_Number");

		// Notes
		$this->Notes->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Notes"));
		$this->Notes->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Notes");
		$this->Notes->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Notes");
		$this->Notes->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Notes"));
		$this->Notes->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Notes");

		// Balance
		$this->Balance->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Balance"));
		$this->Balance->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Balance");
		$this->Balance->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Balance");
		$this->Balance->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Balance"));
		$this->Balance->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Balance");

		// Is_Stock_Available
		$this->Is_Stock_Available->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Is_Stock_Available"));
		$this->Is_Stock_Available->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Is_Stock_Available");
		$this->Is_Stock_Available->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Is_Stock_Available");
		$this->Is_Stock_Available->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Is_Stock_Available"));
		$this->Is_Stock_Available->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Is_Stock_Available");

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

		if ($this->Balance->FormValue == $this->Balance->CurrentValue && is_numeric(ew_StrToFloat($this->Balance->CurrentValue)))
			$this->Balance->CurrentValue = ew_StrToFloat($this->Balance->CurrentValue);

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

		// Supplier_ID
		$this->Supplier_ID->ViewValue = $this->Supplier_ID->CurrentValue;
		$this->Supplier_ID->ViewCustomAttributes = "";

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

			// Supplier_ID
			$this->Supplier_ID->LinkCustomAttributes = "";
			$this->Supplier_ID->HrefValue = "";
			$this->Supplier_ID->TooltipValue = "";

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

			// Balance
			$this->Balance->LinkCustomAttributes = "";
			$this->Balance->HrefValue = "";
			$this->Balance->TooltipValue = "";

			// Is_Stock_Available
			$this->Is_Stock_Available->LinkCustomAttributes = "";
			$this->Is_Stock_Available->HrefValue = "";
			$this->Is_Stock_Available->TooltipValue = "";

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

			// Supplier_ID
			$this->Supplier_ID->EditAttrs["class"] = "form-control";
			$this->Supplier_ID->EditCustomAttributes = "";
			$this->Supplier_ID->EditValue = ew_HtmlEncode($this->Supplier_ID->AdvancedSearch->SearchValue);
			$this->Supplier_ID->PlaceHolder = ew_RemoveHtml($this->Supplier_ID->FldCaption());
			$this->Supplier_ID->EditAttrs["class"] = "form-control";
			$this->Supplier_ID->EditCustomAttributes = "";
			$this->Supplier_ID->EditValue2 = ew_HtmlEncode($this->Supplier_ID->AdvancedSearch->SearchValue2);
			$this->Supplier_ID->PlaceHolder = ew_RemoveHtml($this->Supplier_ID->FldCaption());

			// Supplier_Number
			$this->Supplier_Number->EditAttrs["class"] = "form-control";
			$this->Supplier_Number->EditCustomAttributes = "";
			$this->Supplier_Number->EditValue = ew_HtmlEncode($this->Supplier_Number->AdvancedSearch->SearchValue);
			$this->Supplier_Number->PlaceHolder = ew_RemoveHtml($this->Supplier_Number->FldCaption());
			$this->Supplier_Number->EditAttrs["class"] = "form-control";
			$this->Supplier_Number->EditCustomAttributes = "";
			$this->Supplier_Number->EditValue2 = ew_HtmlEncode($this->Supplier_Number->AdvancedSearch->SearchValue2);
			$this->Supplier_Number->PlaceHolder = ew_RemoveHtml($this->Supplier_Number->FldCaption());

			// Supplier_Name
			$this->Supplier_Name->EditAttrs["class"] = "form-control";
			$this->Supplier_Name->EditCustomAttributes = "";
			$this->Supplier_Name->EditValue = ew_HtmlEncode($this->Supplier_Name->AdvancedSearch->SearchValue);
			$this->Supplier_Name->PlaceHolder = ew_RemoveHtml($this->Supplier_Name->FldCaption());
			$this->Supplier_Name->EditAttrs["class"] = "form-control";
			$this->Supplier_Name->EditCustomAttributes = "";
			$this->Supplier_Name->EditValue2 = ew_HtmlEncode($this->Supplier_Name->AdvancedSearch->SearchValue2);
			$this->Supplier_Name->PlaceHolder = ew_RemoveHtml($this->Supplier_Name->FldCaption());

			// Address
			$this->Address->EditAttrs["class"] = "form-control";
			$this->Address->EditCustomAttributes = "";
			$this->Address->EditValue = ew_HtmlEncode($this->Address->AdvancedSearch->SearchValue);
			$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());
			$this->Address->EditAttrs["class"] = "form-control";
			$this->Address->EditCustomAttributes = "";
			$this->Address->EditValue2 = ew_HtmlEncode($this->Address->AdvancedSearch->SearchValue2);
			$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

			// City
			$this->City->EditAttrs["class"] = "form-control";
			$this->City->EditCustomAttributes = "";
			$this->City->EditValue = ew_HtmlEncode($this->City->AdvancedSearch->SearchValue);
			$this->City->PlaceHolder = ew_RemoveHtml($this->City->FldCaption());
			$this->City->EditAttrs["class"] = "form-control";
			$this->City->EditCustomAttributes = "";
			$this->City->EditValue2 = ew_HtmlEncode($this->City->AdvancedSearch->SearchValue2);
			$this->City->PlaceHolder = ew_RemoveHtml($this->City->FldCaption());

			// Country
			$this->Country->EditAttrs["class"] = "form-control";
			$this->Country->EditCustomAttributes = "";
			$this->Country->EditValue = ew_HtmlEncode($this->Country->AdvancedSearch->SearchValue);
			$this->Country->PlaceHolder = ew_RemoveHtml($this->Country->FldCaption());
			$this->Country->EditAttrs["class"] = "form-control";
			$this->Country->EditCustomAttributes = "";
			$this->Country->EditValue2 = ew_HtmlEncode($this->Country->AdvancedSearch->SearchValue2);
			$this->Country->PlaceHolder = ew_RemoveHtml($this->Country->FldCaption());

			// Contact_Person
			$this->Contact_Person->EditAttrs["class"] = "form-control";
			$this->Contact_Person->EditCustomAttributes = "";
			$this->Contact_Person->EditValue = ew_HtmlEncode($this->Contact_Person->AdvancedSearch->SearchValue);
			$this->Contact_Person->PlaceHolder = ew_RemoveHtml($this->Contact_Person->FldCaption());
			$this->Contact_Person->EditAttrs["class"] = "form-control";
			$this->Contact_Person->EditCustomAttributes = "";
			$this->Contact_Person->EditValue2 = ew_HtmlEncode($this->Contact_Person->AdvancedSearch->SearchValue2);
			$this->Contact_Person->PlaceHolder = ew_RemoveHtml($this->Contact_Person->FldCaption());

			// Phone_Number
			$this->Phone_Number->EditAttrs["class"] = "form-control";
			$this->Phone_Number->EditCustomAttributes = "";
			$this->Phone_Number->EditValue = ew_HtmlEncode($this->Phone_Number->AdvancedSearch->SearchValue);
			$this->Phone_Number->PlaceHolder = ew_RemoveHtml($this->Phone_Number->FldCaption());
			$this->Phone_Number->EditAttrs["class"] = "form-control";
			$this->Phone_Number->EditCustomAttributes = "";
			$this->Phone_Number->EditValue2 = ew_HtmlEncode($this->Phone_Number->AdvancedSearch->SearchValue2);
			$this->Phone_Number->PlaceHolder = ew_RemoveHtml($this->Phone_Number->FldCaption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->AdvancedSearch->SearchValue);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue2 = ew_HtmlEncode($this->_Email->AdvancedSearch->SearchValue2);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

			// Mobile_Number
			$this->Mobile_Number->EditAttrs["class"] = "form-control";
			$this->Mobile_Number->EditCustomAttributes = "";
			$this->Mobile_Number->EditValue = ew_HtmlEncode($this->Mobile_Number->AdvancedSearch->SearchValue);
			$this->Mobile_Number->PlaceHolder = ew_RemoveHtml($this->Mobile_Number->FldCaption());
			$this->Mobile_Number->EditAttrs["class"] = "form-control";
			$this->Mobile_Number->EditCustomAttributes = "";
			$this->Mobile_Number->EditValue2 = ew_HtmlEncode($this->Mobile_Number->AdvancedSearch->SearchValue2);
			$this->Mobile_Number->PlaceHolder = ew_RemoveHtml($this->Mobile_Number->FldCaption());

			// Notes
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue = ew_HtmlEncode($this->Notes->AdvancedSearch->SearchValue);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue2 = ew_HtmlEncode($this->Notes->AdvancedSearch->SearchValue2);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

			// Balance
			$this->Balance->EditAttrs["class"] = "form-control";
			$this->Balance->EditCustomAttributes = "";
			$this->Balance->EditValue = ew_HtmlEncode($this->Balance->AdvancedSearch->SearchValue);
			$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());
			$this->Balance->EditAttrs["class"] = "form-control";
			$this->Balance->EditCustomAttributes = "";
			$this->Balance->EditValue2 = ew_HtmlEncode($this->Balance->AdvancedSearch->SearchValue2);
			$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());

			// Is_Stock_Available
			$this->Is_Stock_Available->EditAttrs["class"] = "form-control";
			$this->Is_Stock_Available->EditCustomAttributes = "";
			$this->Is_Stock_Available->EditValue = $this->Is_Stock_Available->Options(TRUE);
			$this->Is_Stock_Available->EditAttrs["class"] = "form-control";
			$this->Is_Stock_Available->EditCustomAttributes = "";
			$this->Is_Stock_Available->EditValue2 = $this->Is_Stock_Available->Options(TRUE);

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
		if (!ew_CheckInteger($this->Supplier_ID->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Supplier_ID->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Supplier_ID->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Supplier_ID->FldErrMsg());
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
		$this->Supplier_ID->AdvancedSearch->Load();
		$this->Supplier_Number->AdvancedSearch->Load();
		$this->Supplier_Name->AdvancedSearch->Load();
		$this->Address->AdvancedSearch->Load();
		$this->City->AdvancedSearch->Load();
		$this->Country->AdvancedSearch->Load();
		$this->Contact_Person->AdvancedSearch->Load();
		$this->Phone_Number->AdvancedSearch->Load();
		$this->_Email->AdvancedSearch->Load();
		$this->Mobile_Number->AdvancedSearch->Load();
		$this->Notes->AdvancedSearch->Load();
		$this->Balance->AdvancedSearch->Load();
		$this->Is_Stock_Available->AdvancedSearch->Load();
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_supplierslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($a_suppliers_search)) $a_suppliers_search = new ca_suppliers_search();

// Page init
$a_suppliers_search->Page_Init();

// Page main
$a_suppliers_search->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_suppliers_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($a_suppliers_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fa_supplierssearch = new ew_Form("fa_supplierssearch", "search");
<?php } else { ?>
var CurrentForm = fa_supplierssearch = new ew_Form("fa_supplierssearch", "search");
<?php } ?>

// Form_CustomValidate event
fa_supplierssearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_supplierssearch.ValidateRequired = true;
<?php } else { ?>
fa_supplierssearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_supplierssearch.Lists["x_Is_Stock_Available"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_supplierssearch.Lists["x_Is_Stock_Available"].Options = <?php echo json_encode($a_suppliers->Is_Stock_Available->Options()) ?>;

// Form object for search
// Validate function for search

fa_supplierssearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Supplier_ID");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($a_suppliers->Supplier_ID->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$a_suppliers_search->IsModal) { ?>
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
<?php $a_suppliers_search->ShowPageHeader(); ?>
<?php
$a_suppliers_search->ShowMessage();
?>
<form name="fa_supplierssearch" id="fa_supplierssearch" class="<?php echo $a_suppliers_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_suppliers_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_suppliers_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_suppliers">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($a_suppliers_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($a_suppliers->Supplier_ID->Visible) { // Supplier_ID ?>
	<div id="r_Supplier_ID" class="form-group">
		<label for="x_Supplier_ID" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Supplier_ID"><?php echo $a_suppliers->Supplier_ID->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Supplier_ID->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Supplier_ID" id="z_Supplier_ID" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Supplier_ID->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Supplier_ID">
<input type="text" data-table="a_suppliers" data-field="x_Supplier_ID" name="x_Supplier_ID" id="x_Supplier_ID" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_ID->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Supplier_ID->EditValue ?>"<?php echo $a_suppliers->Supplier_ID->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Supplier_ID" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Supplier_ID" class="btw1_Supplier_ID" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Supplier_ID" name="y_Supplier_ID" id="y_Supplier_ID" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_ID->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Supplier_ID->EditValue2 ?>"<?php echo $a_suppliers->Supplier_ID->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Supplier_Number->Visible) { // Supplier_Number ?>
	<div id="r_Supplier_Number" class="form-group">
		<label for="x_Supplier_Number" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Supplier_Number"><?php echo $a_suppliers->Supplier_Number->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Supplier_Number->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Supplier_Number" id="z_Supplier_Number" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Supplier_Number->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Supplier_Number">
<input type="text" data-table="a_suppliers" data-field="x_Supplier_Number" name="x_Supplier_Number" id="x_Supplier_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Supplier_Number->EditValue ?>"<?php echo $a_suppliers->Supplier_Number->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Supplier_Number" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Supplier_Number" class="btw1_Supplier_Number" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Supplier_Number" name="y_Supplier_Number" id="y_Supplier_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Supplier_Number->EditValue2 ?>"<?php echo $a_suppliers->Supplier_Number->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Supplier_Name->Visible) { // Supplier_Name ?>
	<div id="r_Supplier_Name" class="form-group">
		<label for="x_Supplier_Name" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Supplier_Name"><?php echo $a_suppliers->Supplier_Name->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Supplier_Name->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Supplier_Name" id="z_Supplier_Name" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Supplier_Name->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Supplier_Name">
<input type="text" data-table="a_suppliers" data-field="x_Supplier_Name" name="x_Supplier_Name" id="x_Supplier_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_Name->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Supplier_Name->EditValue ?>"<?php echo $a_suppliers->Supplier_Name->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Supplier_Name" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Supplier_Name" class="btw1_Supplier_Name" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Supplier_Name" name="y_Supplier_Name" id="y_Supplier_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_Name->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Supplier_Name->EditValue2 ?>"<?php echo $a_suppliers->Supplier_Name->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Address->Visible) { // Address ?>
	<div id="r_Address" class="form-group">
		<label for="x_Address" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Address"><?php echo $a_suppliers->Address->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Address->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Address" id="z_Address" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Address->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Address">
<input type="text" data-table="a_suppliers" data-field="x_Address" name="x_Address" id="x_Address" size="35" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Address->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Address->EditValue ?>"<?php echo $a_suppliers->Address->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Address" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Address" class="btw1_Address" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Address" name="y_Address" id="y_Address" size="35" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Address->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Address->EditValue2 ?>"<?php echo $a_suppliers->Address->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->City->Visible) { // City ?>
	<div id="r_City" class="form-group">
		<label for="x_City" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_City"><?php echo $a_suppliers->City->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->City->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_City" id="z_City" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->City->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_City">
<input type="text" data-table="a_suppliers" data-field="x_City" name="x_City" id="x_City" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_suppliers->City->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->City->EditValue ?>"<?php echo $a_suppliers->City->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_City" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_City" class="btw1_City" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_City" name="y_City" id="y_City" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_suppliers->City->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->City->EditValue2 ?>"<?php echo $a_suppliers->City->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Country->Visible) { // Country ?>
	<div id="r_Country" class="form-group">
		<label for="x_Country" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Country"><?php echo $a_suppliers->Country->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Country->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Country" id="z_Country" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Country->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Country">
<input type="text" data-table="a_suppliers" data-field="x_Country" name="x_Country" id="x_Country" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Country->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Country->EditValue ?>"<?php echo $a_suppliers->Country->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Country" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Country" class="btw1_Country" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Country" name="y_Country" id="y_Country" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Country->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Country->EditValue2 ?>"<?php echo $a_suppliers->Country->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Contact_Person->Visible) { // Contact_Person ?>
	<div id="r_Contact_Person" class="form-group">
		<label for="x_Contact_Person" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Contact_Person"><?php echo $a_suppliers->Contact_Person->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Contact_Person->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Contact_Person" id="z_Contact_Person" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Contact_Person->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Contact_Person">
<input type="text" data-table="a_suppliers" data-field="x_Contact_Person" name="x_Contact_Person" id="x_Contact_Person" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Contact_Person->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Contact_Person->EditValue ?>"<?php echo $a_suppliers->Contact_Person->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Contact_Person" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Contact_Person" class="btw1_Contact_Person" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Contact_Person" name="y_Contact_Person" id="y_Contact_Person" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Contact_Person->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Contact_Person->EditValue2 ?>"<?php echo $a_suppliers->Contact_Person->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Phone_Number->Visible) { // Phone_Number ?>
	<div id="r_Phone_Number" class="form-group">
		<label for="x_Phone_Number" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Phone_Number"><?php echo $a_suppliers->Phone_Number->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Phone_Number->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Phone_Number" id="z_Phone_Number" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Phone_Number->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Phone_Number">
<input type="text" data-table="a_suppliers" data-field="x_Phone_Number" name="x_Phone_Number" id="x_Phone_Number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Phone_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Phone_Number->EditValue ?>"<?php echo $a_suppliers->Phone_Number->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Phone_Number" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Phone_Number" class="btw1_Phone_Number" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Phone_Number" name="y_Phone_Number" id="y_Phone_Number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Phone_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Phone_Number->EditValue2 ?>"<?php echo $a_suppliers->Phone_Number->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group">
		<label for="x__Email" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers__Email"><?php echo $a_suppliers->_Email->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->_Email->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z__Email" id="z__Email" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->_Email->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers__Email">
<input type="text" data-table="a_suppliers" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($a_suppliers->_Email->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->_Email->EditValue ?>"<?php echo $a_suppliers->_Email->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1__Email" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers__Email" class="btw1__Email" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x__Email" name="y__Email" id="y__Email" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($a_suppliers->_Email->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->_Email->EditValue2 ?>"<?php echo $a_suppliers->_Email->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Mobile_Number->Visible) { // Mobile_Number ?>
	<div id="r_Mobile_Number" class="form-group">
		<label for="x_Mobile_Number" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Mobile_Number"><?php echo $a_suppliers->Mobile_Number->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Mobile_Number->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Mobile_Number" id="z_Mobile_Number" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Mobile_Number->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Mobile_Number">
<input type="text" data-table="a_suppliers" data-field="x_Mobile_Number" name="x_Mobile_Number" id="x_Mobile_Number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Mobile_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Mobile_Number->EditValue ?>"<?php echo $a_suppliers->Mobile_Number->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Mobile_Number" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Mobile_Number" class="btw1_Mobile_Number" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Mobile_Number" name="y_Mobile_Number" id="y_Mobile_Number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Mobile_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Mobile_Number->EditValue2 ?>"<?php echo $a_suppliers->Mobile_Number->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Notes->Visible) { // Notes ?>
	<div id="r_Notes" class="form-group">
		<label for="x_Notes" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Notes"><?php echo $a_suppliers->Notes->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Notes->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Notes" id="z_Notes" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Notes->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Notes">
<input type="text" data-table="a_suppliers" data-field="x_Notes" name="x_Notes" id="x_Notes" size="35" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Notes->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Notes->EditValue ?>"<?php echo $a_suppliers->Notes->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Notes" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Notes" class="btw1_Notes" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Notes" name="y_Notes" id="y_Notes" size="35" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Notes->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Notes->EditValue2 ?>"<?php echo $a_suppliers->Notes->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Balance->Visible) { // Balance ?>
	<div id="r_Balance" class="form-group">
		<label for="x_Balance" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Balance"><?php echo $a_suppliers->Balance->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Balance->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Balance" id="z_Balance" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Balance->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Balance">
<input type="text" data-table="a_suppliers" data-field="x_Balance" name="x_Balance" id="x_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Balance->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Balance->EditValue ?>"<?php echo $a_suppliers->Balance->EditAttributes() ?>>
<?php if (!$a_suppliers->Balance->ReadOnly && !$a_suppliers->Balance->Disabled && @$a_suppliers->Balance->EditAttrs["readonly"] == "" && @$a_suppliers->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Balance" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Balance" class="btw1_Balance" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Balance" name="y_Balance" id="y_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Balance->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Balance->EditValue2 ?>"<?php echo $a_suppliers->Balance->EditAttributes() ?>>
<?php if (!$a_suppliers->Balance->ReadOnly && !$a_suppliers->Balance->Disabled && @$a_suppliers->Balance->EditAttrs["readonly"] == "" && @$a_suppliers->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Is_Stock_Available->Visible) { // Is_Stock_Available ?>
	<div id="r_Is_Stock_Available" class="form-group">
		<label for="x_Is_Stock_Available" class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Is_Stock_Available"><?php echo $a_suppliers->Is_Stock_Available->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Is_Stock_Available->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Is_Stock_Available" id="z_Is_Stock_Available" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Is_Stock_Available">
<select data-table="a_suppliers" data-field="x_Is_Stock_Available" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_suppliers->Is_Stock_Available->DisplayValueSeparator) ? json_encode($a_suppliers->Is_Stock_Available->DisplayValueSeparator) : $a_suppliers->Is_Stock_Available->DisplayValueSeparator) ?>" id="x_Is_Stock_Available" name="x_Is_Stock_Available"<?php echo $a_suppliers->Is_Stock_Available->EditAttributes() ?>>
<?php
if (is_array($a_suppliers->Is_Stock_Available->EditValue)) {
	$arwrk = $a_suppliers->Is_Stock_Available->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_suppliers->Is_Stock_Available->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_suppliers->Is_Stock_Available->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_suppliers->Is_Stock_Available->CurrentValue) ?>" selected><?php echo $a_suppliers->Is_Stock_Available->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
			<span class="ewSearchCond btw1_Is_Stock_Available" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Is_Stock_Available" class="btw1_Is_Stock_Available" style="display: none">
<select data-table="a_suppliers" data-field="x_Is_Stock_Available" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_suppliers->Is_Stock_Available->DisplayValueSeparator) ? json_encode($a_suppliers->Is_Stock_Available->DisplayValueSeparator) : $a_suppliers->Is_Stock_Available->DisplayValueSeparator) ?>" id="y_Is_Stock_Available" name="y_Is_Stock_Available"<?php echo $a_suppliers->Is_Stock_Available->EditAttributes() ?>>
<?php
if (is_array($a_suppliers->Is_Stock_Available->EditValue2)) {
	$arwrk = $a_suppliers->Is_Stock_Available->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_suppliers->Is_Stock_Available->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_suppliers->Is_Stock_Available->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_suppliers->Is_Stock_Available->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_suppliers->Is_Stock_Available->CurrentValue) ?>" selected><?php echo $a_suppliers->Is_Stock_Available->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Date_Added->Visible) { // Date_Added ?>
	<div id="r_Date_Added" class="form-group">
		<label class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Date_Added"><?php echo $a_suppliers->Date_Added->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Date_Added->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Added" id="z_Date_Added" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Date_Added->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Date_Added">
<input type="text" data-table="a_suppliers" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Date_Added->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Date_Added->EditValue ?>"<?php echo $a_suppliers->Date_Added->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Date_Added" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Date_Added" class="btw1_Date_Added" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Date_Added" name="y_Date_Added" id="y_Date_Added" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Date_Added->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Date_Added->EditValue2 ?>"<?php echo $a_suppliers->Date_Added->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Added_By->Visible) { // Added_By ?>
	<div id="r_Added_By" class="form-group">
		<label class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Added_By"><?php echo $a_suppliers->Added_By->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Added_By->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Added_By" id="z_Added_By" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Added_By->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Added_By">
<input type="text" data-table="a_suppliers" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Added_By->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Added_By->EditValue ?>"<?php echo $a_suppliers->Added_By->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Added_By" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Added_By" class="btw1_Added_By" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Added_By" name="y_Added_By" id="y_Added_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Added_By->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Added_By->EditValue2 ?>"<?php echo $a_suppliers->Added_By->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Date_Updated->Visible) { // Date_Updated ?>
	<div id="r_Date_Updated" class="form-group">
		<label class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Date_Updated"><?php echo $a_suppliers->Date_Updated->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Date_Updated->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Updated" id="z_Date_Updated" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Date_Updated->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Date_Updated">
<input type="text" data-table="a_suppliers" data-field="x_Date_Updated" name="x_Date_Updated" id="x_Date_Updated" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Date_Updated->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Date_Updated->EditValue ?>"<?php echo $a_suppliers->Date_Updated->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Date_Updated" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Date_Updated" class="btw1_Date_Updated" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Date_Updated" name="y_Date_Updated" id="y_Date_Updated" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Date_Updated->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Date_Updated->EditValue2 ?>"<?php echo $a_suppliers->Date_Updated->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Updated_By->Visible) { // Updated_By ?>
	<div id="r_Updated_By" class="form-group">
		<label class="<?php echo $a_suppliers_search->SearchLabelClass ?>"><span id="elh_a_suppliers_Updated_By"><?php echo $a_suppliers->Updated_By->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_suppliers_search->SearchRightColumnClass ?>"><div<?php echo $a_suppliers->Updated_By->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Updated_By" id="z_Updated_By" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_suppliers->Updated_By->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_suppliers_Updated_By">
<input type="text" data-table="a_suppliers" data-field="x_Updated_By" name="x_Updated_By" id="x_Updated_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Updated_By->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Updated_By->EditValue ?>"<?php echo $a_suppliers->Updated_By->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Updated_By" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_suppliers_Updated_By" class="btw1_Updated_By" style="display: none">
<input type="text" data-table="a_suppliers" data-field="x_Updated_By" name="y_Updated_By" id="y_Updated_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Updated_By->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Updated_By->EditValue2 ?>"<?php echo $a_suppliers->Updated_By->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$a_suppliers_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fa_supplierssearch.Init();
</script>
<?php
$a_suppliers_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_supplierssearch:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_suppliers_search->Page_Terminate();
?>
