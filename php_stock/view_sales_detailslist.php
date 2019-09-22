<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "view_sales_detailsinfo.php" ?>
<?php include_once "a_stock_itemsinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$view_sales_details_list = NULL; // Initialize page object first

class cview_sales_details_list extends cview_sales_details {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'view_sales_details';

	// Page object name
	var $PageObjName = 'view_sales_details_list';

	// Grid form hidden field names
	var $FormName = 'fview_sales_detailslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (view_sales_details)
		if (!isset($GLOBALS["view_sales_details"]) || get_class($GLOBALS["view_sales_details"]) == "cview_sales_details") {
			$GLOBALS["view_sales_details"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["view_sales_details"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "view_sales_detailsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "view_sales_detailsdelete.php";
		$this->MultiUpdateUrl = "view_sales_detailsupdate.php";

		// Table object (a_stock_items)
		if (!isset($GLOBALS['a_stock_items'])) $GLOBALS['a_stock_items'] = new ca_stock_items();

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'view_sales_details', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (users)
		if (!isset($UserTable)) {
			$UserTable = new cusers();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fview_sales_detailslistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm, $UserTableConn;
		if (!isset($_SESSION['table_view_sales_details_views'])) { 
			$_SESSION['table_view_sales_details_views'] = 0;
		}
		$_SESSION['table_view_sales_details_views'] = $_SESSION['table_view_sales_details_views']+1;

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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
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

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Begin of modification Permission Access for Export To Feature, by Masino Sinaga, To prevent users entering from URL, May 12, 2012
		global $gsExport;
		if ($gsExport=="print") {
			if (!$Security->CanExportToPrint() && !$Security->IsAdmin()) {
				echo $Language->Phrase("nopermission");
				exit();
			}
		} elseif ($gsExport=="excel") {
			if (!$Security->CanExportToExcel() && !$Security->IsAdmin()) {
				echo $Language->Phrase("nopermission");
				exit();
			}   
		} elseif ($gsExport=="word") {
			if (!$Security->CanExportToWord() && !$Security->IsAdmin()) {
				echo $Language->Phrase("nopermission");
				exit();
			}   
		} elseif ($gsExport=="html") {
			if (!$Security->CanExportToHTML() && !$Security->IsAdmin()) {
				echo $Language->Phrase("nopermission");
				exit();
			}   
		} elseif ($gsExport=="csv") {
			if (!$Security->CanExportToCSV() && !$Security->IsAdmin()) {
				echo $Language->Phrase("nopermission");
				exit();
			}   
		} elseif ($gsExport=="xml") {
			if (!$Security->CanExportToXML() && !$Security->IsAdmin()) {
				echo $Language->Phrase("nopermission");
				exit();
			}   
		} elseif ($gsExport=="pdf") {
			if (!$Security->CanExportToPDF() && !$Security->IsAdmin()) {
				echo $Language->Phrase("nopermission");
				exit();
			}   
		} elseif ($gsExport=="email") {
			if (!$Security->CanExportToEmail() && !$Security->IsAdmin()) {
				echo $Language->Phrase("nopermission");
				exit();
			}   
		}

		// End of modification Permission Access for Export To Feature, by Masino Sinaga, To prevent users entering from URL, May 12, 2012
		// Get custom export parameters

		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $view_sales_details;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($view_sales_details);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;

// Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012
    var $DisplayRecs = MS_TABLE_RECPERPAGE_VALUE;

// End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012
	var $SearchPanelCollapsed = TRUE; // Modified by Masino Sinaga, September 23, 2014
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Restore filter list
			$this->RestoreFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {

			// Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012
			$this->DisplayRecs = MS_TABLE_RECPERPAGE_VALUE; // Load default

			// End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "a_stock_items") {
			global $a_stock_items;
			$rsmaster = $a_stock_items->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("a_stock_itemslist.php"); // Return to master page
			} else {
				$a_stock_items->LoadListRowValues($rsmaster);
				$a_stock_items->RowType = EW_ROWTYPE_MASTER; // Master row
				$a_stock_items->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

	// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012     
		if ((MS_EXPORT_RECORD_OPTIONS=="selectedrecords") && (CurrentPageID() == "list")) {

			// Export selected records
			if ($this->Export <> "")
				$this->CurrentFilter = $this->BuildExportSelectedFilter();
		}

	// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
		// Export data only
		// Begin of modification Printer Friendly always does not use stylesheet, by Masino Sinaga, October 8, 2013 (added "print" in array)

		if ($this->CustomExport == "" && in_array($this->Export, array("html","print","word","excel","xml","csv","email","pdf"))) {

		// End of modification Printer Friendly always does not use stylesheet, by Masino Sinaga, October 8, 2013
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) { // begin of v11.0.4
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		} // end of v11.0.4

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {

	// Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012
        global $Language;
        $sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
        if ($sWrk > MS_TABLE_MAXIMUM_SELECTED_RECORDS || strtolower($sWrk) == "all") {
            $sWrk = MS_TABLE_MAXIMUM_SELECTED_RECORDS;
            $this->setFailureMessage(str_replace("%t", MS_TABLE_MAXIMUM_SELECTED_RECORDS, $Language->Phrase("MaximumRecordsPerPage")));
        }

	// End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->Sales_ID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Sales_ID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Sales_ID->AdvancedSearch->ToJSON(), ","); // Field Sales_ID
		$sFilterList = ew_Concat($sFilterList, $this->Sales_Number->AdvancedSearch->ToJSON(), ","); // Field Sales_Number
		$sFilterList = ew_Concat($sFilterList, $this->Supplier_Number->AdvancedSearch->ToJSON(), ","); // Field Supplier_Number
		$sFilterList = ew_Concat($sFilterList, $this->Stock_Item->AdvancedSearch->ToJSON(), ","); // Field Stock_Item
		$sFilterList = ew_Concat($sFilterList, $this->Sales_Quantity->AdvancedSearch->ToJSON(), ","); // Field Sales_Quantity
		$sFilterList = ew_Concat($sFilterList, $this->Purchasing_Price->AdvancedSearch->ToJSON(), ","); // Field Purchasing_Price
		$sFilterList = ew_Concat($sFilterList, $this->Sales_Price->AdvancedSearch->ToJSON(), ","); // Field Sales_Price
		$sFilterList = ew_Concat($sFilterList, $this->Sales_Total_Amount->AdvancedSearch->ToJSON(), ","); // Field Sales_Total_Amount
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}

		// Return filter list in json
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field Sales_ID
		$this->Sales_ID->AdvancedSearch->SearchValue = @$filter["x_Sales_ID"];
		$this->Sales_ID->AdvancedSearch->SearchOperator = @$filter["z_Sales_ID"];
		$this->Sales_ID->AdvancedSearch->SearchCondition = @$filter["v_Sales_ID"];
		$this->Sales_ID->AdvancedSearch->SearchValue2 = @$filter["y_Sales_ID"];
		$this->Sales_ID->AdvancedSearch->SearchOperator2 = @$filter["w_Sales_ID"];
		$this->Sales_ID->AdvancedSearch->Save();

		// Field Sales_Number
		$this->Sales_Number->AdvancedSearch->SearchValue = @$filter["x_Sales_Number"];
		$this->Sales_Number->AdvancedSearch->SearchOperator = @$filter["z_Sales_Number"];
		$this->Sales_Number->AdvancedSearch->SearchCondition = @$filter["v_Sales_Number"];
		$this->Sales_Number->AdvancedSearch->SearchValue2 = @$filter["y_Sales_Number"];
		$this->Sales_Number->AdvancedSearch->SearchOperator2 = @$filter["w_Sales_Number"];
		$this->Sales_Number->AdvancedSearch->Save();

		// Field Supplier_Number
		$this->Supplier_Number->AdvancedSearch->SearchValue = @$filter["x_Supplier_Number"];
		$this->Supplier_Number->AdvancedSearch->SearchOperator = @$filter["z_Supplier_Number"];
		$this->Supplier_Number->AdvancedSearch->SearchCondition = @$filter["v_Supplier_Number"];
		$this->Supplier_Number->AdvancedSearch->SearchValue2 = @$filter["y_Supplier_Number"];
		$this->Supplier_Number->AdvancedSearch->SearchOperator2 = @$filter["w_Supplier_Number"];
		$this->Supplier_Number->AdvancedSearch->Save();

		// Field Stock_Item
		$this->Stock_Item->AdvancedSearch->SearchValue = @$filter["x_Stock_Item"];
		$this->Stock_Item->AdvancedSearch->SearchOperator = @$filter["z_Stock_Item"];
		$this->Stock_Item->AdvancedSearch->SearchCondition = @$filter["v_Stock_Item"];
		$this->Stock_Item->AdvancedSearch->SearchValue2 = @$filter["y_Stock_Item"];
		$this->Stock_Item->AdvancedSearch->SearchOperator2 = @$filter["w_Stock_Item"];
		$this->Stock_Item->AdvancedSearch->Save();

		// Field Sales_Quantity
		$this->Sales_Quantity->AdvancedSearch->SearchValue = @$filter["x_Sales_Quantity"];
		$this->Sales_Quantity->AdvancedSearch->SearchOperator = @$filter["z_Sales_Quantity"];
		$this->Sales_Quantity->AdvancedSearch->SearchCondition = @$filter["v_Sales_Quantity"];
		$this->Sales_Quantity->AdvancedSearch->SearchValue2 = @$filter["y_Sales_Quantity"];
		$this->Sales_Quantity->AdvancedSearch->SearchOperator2 = @$filter["w_Sales_Quantity"];
		$this->Sales_Quantity->AdvancedSearch->Save();

		// Field Purchasing_Price
		$this->Purchasing_Price->AdvancedSearch->SearchValue = @$filter["x_Purchasing_Price"];
		$this->Purchasing_Price->AdvancedSearch->SearchOperator = @$filter["z_Purchasing_Price"];
		$this->Purchasing_Price->AdvancedSearch->SearchCondition = @$filter["v_Purchasing_Price"];
		$this->Purchasing_Price->AdvancedSearch->SearchValue2 = @$filter["y_Purchasing_Price"];
		$this->Purchasing_Price->AdvancedSearch->SearchOperator2 = @$filter["w_Purchasing_Price"];
		$this->Purchasing_Price->AdvancedSearch->Save();

		// Field Sales_Price
		$this->Sales_Price->AdvancedSearch->SearchValue = @$filter["x_Sales_Price"];
		$this->Sales_Price->AdvancedSearch->SearchOperator = @$filter["z_Sales_Price"];
		$this->Sales_Price->AdvancedSearch->SearchCondition = @$filter["v_Sales_Price"];
		$this->Sales_Price->AdvancedSearch->SearchValue2 = @$filter["y_Sales_Price"];
		$this->Sales_Price->AdvancedSearch->SearchOperator2 = @$filter["w_Sales_Price"];
		$this->Sales_Price->AdvancedSearch->Save();

		// Field Sales_Total_Amount
		$this->Sales_Total_Amount->AdvancedSearch->SearchValue = @$filter["x_Sales_Total_Amount"];
		$this->Sales_Total_Amount->AdvancedSearch->SearchOperator = @$filter["z_Sales_Total_Amount"];
		$this->Sales_Total_Amount->AdvancedSearch->SearchCondition = @$filter["v_Sales_Total_Amount"];
		$this->Sales_Total_Amount->AdvancedSearch->SearchValue2 = @$filter["y_Sales_Total_Amount"];
		$this->Sales_Total_Amount->AdvancedSearch->SearchOperator2 = @$filter["w_Sales_Total_Amount"];
		$this->Sales_Total_Amount->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Sales_ID, $Default, FALSE); // Sales_ID
		$this->BuildSearchSql($sWhere, $this->Sales_Number, $Default, FALSE); // Sales_Number
		$this->BuildSearchSql($sWhere, $this->Supplier_Number, $Default, FALSE); // Supplier_Number
		$this->BuildSearchSql($sWhere, $this->Stock_Item, $Default, FALSE); // Stock_Item
		$this->BuildSearchSql($sWhere, $this->Sales_Quantity, $Default, FALSE); // Sales_Quantity
		$this->BuildSearchSql($sWhere, $this->Purchasing_Price, $Default, FALSE); // Purchasing_Price
		$this->BuildSearchSql($sWhere, $this->Sales_Price, $Default, FALSE); // Sales_Price
		$this->BuildSearchSql($sWhere, $this->Sales_Total_Amount, $Default, FALSE); // Sales_Total_Amount

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Sales_ID->AdvancedSearch->Save(); // Sales_ID
			$this->Sales_Number->AdvancedSearch->Save(); // Sales_Number
			$this->Supplier_Number->AdvancedSearch->Save(); // Supplier_Number
			$this->Stock_Item->AdvancedSearch->Save(); // Stock_Item
			$this->Sales_Quantity->AdvancedSearch->Save(); // Sales_Quantity
			$this->Purchasing_Price->AdvancedSearch->Save(); // Purchasing_Price
			$this->Sales_Price->AdvancedSearch->Save(); // Sales_Price
			$this->Sales_Total_Amount->AdvancedSearch->Save(); // Sales_Total_Amount
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Sales_Number, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Supplier_Number, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Stock_Item, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}

					// Begin of modification Exact Match search criteria, by Masino Sinaga, November 12, 2014. See also: http://www.hkvforums.com/viewtopic.php?f=4&t=35853&p=104026#p104026
					if ($type == "=") {
						$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
						$sWrk = $sFldExpression . " = " . ew_QuotedValue("" . $Keyword . "", EW_DATATYPE_STRING);
					}

					// End of modification Exact Match search criteria, by Masino Sinaga, November 12, 2014. See also: http://www.hkvforums.com/viewtopic.php?f=4&t=35853&p=104026#p104026
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->Sales_ID->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sales_Number->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Supplier_Number->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Stock_Item->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sales_Quantity->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Purchasing_Price->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sales_Price->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sales_Total_Amount->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->Sales_ID->AdvancedSearch->UnsetSession();
		$this->Sales_Number->AdvancedSearch->UnsetSession();
		$this->Supplier_Number->AdvancedSearch->UnsetSession();
		$this->Stock_Item->AdvancedSearch->UnsetSession();
		$this->Sales_Quantity->AdvancedSearch->UnsetSession();
		$this->Purchasing_Price->AdvancedSearch->UnsetSession();
		$this->Sales_Price->AdvancedSearch->UnsetSession();
		$this->Sales_Total_Amount->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Sales_ID->AdvancedSearch->Load();
		$this->Sales_Number->AdvancedSearch->Load();
		$this->Supplier_Number->AdvancedSearch->Load();
		$this->Stock_Item->AdvancedSearch->Load();
		$this->Sales_Quantity->AdvancedSearch->Load();
		$this->Purchasing_Price->AdvancedSearch->Load();
		$this->Sales_Price->AdvancedSearch->Load();
		$this->Sales_Total_Amount->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Sales_Number); // Sales_Number
			$this->UpdateSort($this->Supplier_Number); // Supplier_Number
			$this->UpdateSort($this->Stock_Item); // Stock_Item
			$this->UpdateSort($this->Sales_Quantity); // Sales_Quantity
			$this->UpdateSort($this->Purchasing_Price); // Purchasing_Price
			$this->UpdateSort($this->Sales_Price); // Sales_Price
			$this->UpdateSort($this->Sales_Total_Amount); // Sales_Total_Amount
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->Stock_Item->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Sales_Number->setSort("");
				$this->Supplier_Number->setSort("");
				$this->Stock_Item->setSort("");
				$this->Sales_Quantity->setSort("");
				$this->Purchasing_Price->setSort("");
				$this->Sales_Price->setSort("");
				$this->Sales_Total_Amount->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt) {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Sales_ID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fview_sales_detailslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fview_sales_detailslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fview_sales_detailslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");

		// Begin of modification Customizing Search Panel, by Masino Sinaga, for customize search panel, July 22, 2014
		if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_COLLAPSED) {			

			// The code in this first block will be generated if "UseTableSettingForSearchPanelCollapsed" is enabled from "MasinoFixedWidthSite12" extension, also with "InitSearchPanelAsCollapsed" is enabled from -> "Advanced" -> "Tables" setting.
			if ($this->SearchPanelCollapsed==TRUE) {
				$SearchToggleClass = " ";
			} else {
				$SearchToggleClass = " active";
			}
		} else {

			// Nothing to do, because we've been using MS_SEARCH_PANEL_COLLAPSED value from the generated "ewcfg11.php" file
			// $SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active"; // <-- no need to use this anymore!

			if (MS_SEARCH_PANEL_COLLAPSED == TRUE && $this->SearchWhere <> "") {
				$SearchToggleClass = " active";
			} elseif (MS_SEARCH_PANEL_COLLAPSED == TRUE && $this->SearchWhere == "") {
				$SearchToggleClass = " ";
			} elseif (MS_SEARCH_PANEL_COLLAPSED == FALSE && $this->SearchWhere <> "") {
				$SearchToggleClass = " active";			
			} elseif (MS_SEARCH_PANEL_COLLAPSED == FALSE && $this->SearchWhere == "") {
				$SearchToggleClass = " active";
			}
		}

		// End of modification Customizing Search Panel, by Masino Sinaga, for customize search panel, July 22, 2014
		// Begin of modification Hide Search Button for Inline Edit and Inline Copy mode in List Page, by Masino Sinaga, August 4, 2014

		if ($this->CurrentAction == "edit" || $this->CurrentAction == "copy") {
		} else {
			$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fview_sales_detailslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
			$item->Visible = TRUE;
		}

		// End of modification Hide Search Button for Inline Edit and Inline Copy mode in List Page, by Masino Sinaga, August 4, 2014			
		// Begin of modification Hide Search Button for Inline Edit and Inline Copy mode in List Page, by Masino Sinaga, August 4, 2014

		if ($this->CurrentAction == "edit" || $this->CurrentAction == "copy") {
		} else {

			// Show all button
			$item = &$this->SearchOptions->Add("showall");
			$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
			$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101"); // v11.0.4
		}

		// End of modification Hide Search Button for Inline Edit and Inline Copy mode in List Page, by Masino Sinaga, August 4, 2014
		// Advanced search button

		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"view_sales_detailssrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;

		// Hide detail items for dropdown if necessary
		$this->ListOptions->HideDetailItemsForDropDown();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Sales_ID

		$this->Sales_ID->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sales_ID"]);
		if ($this->Sales_ID->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sales_ID->AdvancedSearch->SearchOperator = @$_GET["z_Sales_ID"];
		$this->Sales_ID->AdvancedSearch->SearchCondition = @$_GET["v_Sales_ID"];
		$this->Sales_ID->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Sales_ID"]);
		if ($this->Sales_ID->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Sales_ID->AdvancedSearch->SearchOperator2 = @$_GET["w_Sales_ID"];

		// Sales_Number
		$this->Sales_Number->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sales_Number"]);
		if ($this->Sales_Number->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sales_Number->AdvancedSearch->SearchOperator = @$_GET["z_Sales_Number"];
		$this->Sales_Number->AdvancedSearch->SearchCondition = @$_GET["v_Sales_Number"];
		$this->Sales_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Sales_Number"]);
		if ($this->Sales_Number->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Sales_Number->AdvancedSearch->SearchOperator2 = @$_GET["w_Sales_Number"];

		// Supplier_Number
		$this->Supplier_Number->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Supplier_Number"]);
		if ($this->Supplier_Number->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Supplier_Number->AdvancedSearch->SearchOperator = @$_GET["z_Supplier_Number"];
		$this->Supplier_Number->AdvancedSearch->SearchCondition = @$_GET["v_Supplier_Number"];
		$this->Supplier_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Supplier_Number"]);
		if ($this->Supplier_Number->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Supplier_Number->AdvancedSearch->SearchOperator2 = @$_GET["w_Supplier_Number"];

		// Stock_Item
		$this->Stock_Item->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Stock_Item"]);
		if ($this->Stock_Item->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Stock_Item->AdvancedSearch->SearchOperator = @$_GET["z_Stock_Item"];
		$this->Stock_Item->AdvancedSearch->SearchCondition = @$_GET["v_Stock_Item"];
		$this->Stock_Item->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Stock_Item"]);
		if ($this->Stock_Item->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Stock_Item->AdvancedSearch->SearchOperator2 = @$_GET["w_Stock_Item"];

		// Sales_Quantity
		$this->Sales_Quantity->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sales_Quantity"]);
		if ($this->Sales_Quantity->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sales_Quantity->AdvancedSearch->SearchOperator = @$_GET["z_Sales_Quantity"];
		$this->Sales_Quantity->AdvancedSearch->SearchCondition = @$_GET["v_Sales_Quantity"];
		$this->Sales_Quantity->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Sales_Quantity"]);
		if ($this->Sales_Quantity->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Sales_Quantity->AdvancedSearch->SearchOperator2 = @$_GET["w_Sales_Quantity"];

		// Purchasing_Price
		$this->Purchasing_Price->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Purchasing_Price"]);
		if ($this->Purchasing_Price->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Purchasing_Price->AdvancedSearch->SearchOperator = @$_GET["z_Purchasing_Price"];
		$this->Purchasing_Price->AdvancedSearch->SearchCondition = @$_GET["v_Purchasing_Price"];
		$this->Purchasing_Price->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Purchasing_Price"]);
		if ($this->Purchasing_Price->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Purchasing_Price->AdvancedSearch->SearchOperator2 = @$_GET["w_Purchasing_Price"];

		// Sales_Price
		$this->Sales_Price->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sales_Price"]);
		if ($this->Sales_Price->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sales_Price->AdvancedSearch->SearchOperator = @$_GET["z_Sales_Price"];
		$this->Sales_Price->AdvancedSearch->SearchCondition = @$_GET["v_Sales_Price"];
		$this->Sales_Price->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Sales_Price"]);
		if ($this->Sales_Price->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Sales_Price->AdvancedSearch->SearchOperator2 = @$_GET["w_Sales_Price"];

		// Sales_Total_Amount
		$this->Sales_Total_Amount->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sales_Total_Amount"]);
		if ($this->Sales_Total_Amount->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sales_Total_Amount->AdvancedSearch->SearchOperator = @$_GET["z_Sales_Total_Amount"];
		$this->Sales_Total_Amount->AdvancedSearch->SearchCondition = @$_GET["v_Sales_Total_Amount"];
		$this->Sales_Total_Amount->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Sales_Total_Amount"]);
		if ($this->Sales_Total_Amount->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Sales_Total_Amount->AdvancedSearch->SearchOperator2 = @$_GET["w_Sales_Total_Amount"];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

		$this->Sales_ID->CellCssStyle = "white-space: nowrap;";

		// Sales_Number
		// Supplier_Number
		// Stock_Item
		// Sales_Quantity
		// Purchasing_Price
		// Sales_Price
		// Sales_Total_Amount
		// Accumulate aggregate value

		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT && $this->RowType <> EW_ROWTYPE_AGGREGATE) {
			if (is_numeric($this->Sales_Quantity->CurrentValue))
				$this->Sales_Quantity->Total += $this->Sales_Quantity->CurrentValue; // Accumulate total
			if (is_numeric($this->Sales_Total_Amount->CurrentValue))
				$this->Sales_Total_Amount->Total += $this->Sales_Total_Amount->CurrentValue; // Accumulate total
		}
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
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
			$this->Sales_Quantity->Total = 0; // Initialize total
			$this->Sales_Total_Amount->Total = 0; // Initialize total
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATE) { // Aggregate row
			$this->Sales_Quantity->CurrentValue = $this->Sales_Quantity->Total;
			$this->Sales_Quantity->ViewValue = $this->Sales_Quantity->CurrentValue;
			$this->Sales_Quantity->ViewValue = ew_FormatNumber($this->Sales_Quantity->ViewValue, 0, -2, -2, -2);
			$this->Sales_Quantity->CellCssStyle .= "text-align: right;";
			$this->Sales_Quantity->ViewCustomAttributes = "";
			$this->Sales_Quantity->HrefValue = ""; // Clear href value
			$this->Sales_Total_Amount->CurrentValue = $this->Sales_Total_Amount->Total;
			$this->Sales_Total_Amount->ViewValue = $this->Sales_Total_Amount->CurrentValue;
			$this->Sales_Total_Amount->ViewValue = ew_FormatCurrency($this->Sales_Total_Amount->ViewValue, 2, -2, -2, -2);
			$this->Sales_Total_Amount->CellCssStyle .= "text-align: right;";
			$this->Sales_Total_Amount->ViewCustomAttributes = "";
			$this->Sales_Total_Amount->HrefValue = ""; // Clear href value
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
		$this->Supplier_Number->AdvancedSearch->Load();
		$this->Stock_Item->AdvancedSearch->Load();
		$this->Sales_Quantity->AdvancedSearch->Load();
		$this->Purchasing_Price->AdvancedSearch->Load();
		$this->Sales_Price->AdvancedSearch->Load();
		$this->Sales_Total_Amount->AdvancedSearch->Load();
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

	// Set up export options
	function SetupExportOptions() {

// Begin of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012
        global $Language, $Security, $view_sales_details; // <-- Added $Security variable by Masino Sinaga

		// Printer friendly
        if ($Security->CanExportToPrint() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("print");

			// $item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

			if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
				$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fview_sales_detailslist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
			} else {
				$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
			}

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Excel
        if ($Security->CanExportToExcel() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("excel");

			// $item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

			if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
				$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fview_sales_detailslist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
			} else {
				$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
			}

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Word
        if ($Security->CanExportToWord() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("word");

			// $item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

			if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
				$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fview_sales_detailslist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
			} else {
				$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
			}

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Html
        if ($Security->CanExportToHTML() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("html");

			// $item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

			if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
				$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fview_sales_detailslist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
			} else {
				$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHTML") . "</a>";
			}

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Xml
        if ($Security->CanExportToXML() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("xml");

			// $item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

			if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
				$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fview_sales_detailslist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
			} else {
				$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXML") . "</a>";
			}

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Csv
        if ($Security->CanExportToCSV() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("csv");

			// $item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

			if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
				$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fview_sales_detailslist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
			} else {
				$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCSV") . "</a>";
			}

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Pdf
        if ($Security->CanExportToPDF() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("pdf");

			// $item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

			if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
				$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fview_sales_detailslist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
			} else {
				$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
			}

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = FALSE;
        }

		// Export to Email
		if ($Security->CanExportToEmail() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("email");
			$url = "";

			// $item->Body = "<button id=\"emf_view_sales_details\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_view_sales_details',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fview_sales_detailslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

		if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
			$item->Body = "<a id=\"emf_view_sales_details\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\"  data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_view_sales_details',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fview_sales_detailslist,sel:true});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		} else {
			$item->Body = "<a id=\"emf_view_sales_details\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\"  data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_view_sales_details',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fview_sales_detailslist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		}

		// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {

			// changed since v11.0.6
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

		if ($this->ExportAll=="allpages") {

		// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "a_stock_items") {
			global $a_stock_items;
			if (!isset($a_stock_items)) $a_stock_items = new ca_stock_items;
			$rsmaster = $a_stock_items->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$a_stock_items; // v11.0.4
					$a_stock_items->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this; // v11.0.4
				}
				$rsmaster->Close();
			}
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];
		$sContentType = @$_POST["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_POST["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_POST["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= ew_CleanEmailContent($EmailContent); // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();

		// Begin of changes, since v11.0.6
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}

		// End of changes, since v11.0.6
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<div class=\"alert alert-success ewSuccess\">" . $Language->Phrase("SendEmailSuccess") . "</div>"; // Set up success message
		} else {

			// Sent email failure
			return "<div class=\"alert alert-danger ewError\">" . $Email->SendErrDescription . "</div>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Build QueryString for search
		if ($this->BasicSearch->getKeyword() <> "") {
			$sQry .= "&" . EW_TABLE_BASIC_SEARCH . "=" . urlencode($this->BasicSearch->getKeyword()) . "&" . EW_TABLE_BASIC_SEARCH_TYPE . "=" . urlencode($this->BasicSearch->getType());
		}
		$this->AddSearchQueryString($sQry, $this->Sales_ID); // Sales_ID
		$this->AddSearchQueryString($sQry, $this->Sales_Number); // Sales_Number
		$this->AddSearchQueryString($sQry, $this->Supplier_Number); // Supplier_Number
		$this->AddSearchQueryString($sQry, $this->Stock_Item); // Stock_Item
		$this->AddSearchQueryString($sQry, $this->Sales_Quantity); // Sales_Quantity
		$this->AddSearchQueryString($sQry, $this->Purchasing_Price); // Purchasing_Price
		$this->AddSearchQueryString($sQry, $this->Sales_Price); // Sales_Price
		$this->AddSearchQueryString($sQry, $this->Sales_Total_Amount); // Sales_Total_Amount

		// Build QueryString for pager
		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
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
			if ($sMasterTblVar == "a_stock_items") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Stock_Number"] <> "") {
					$GLOBALS["a_stock_items"]->Stock_Number->setQueryStringValue($_GET["fk_Stock_Number"]);
					$this->Stock_Item->setQueryStringValue($GLOBALS["a_stock_items"]->Stock_Number->QueryStringValue);
					$this->Stock_Item->setSessionValue($this->Stock_Item->QueryStringValue);
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
			if ($sMasterTblVar == "a_stock_items") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Stock_Number"] <> "") {
					$GLOBALS["a_stock_items"]->Stock_Number->setFormValue($_POST["fk_Stock_Number"]);
					$this->Stock_Item->setFormValue($GLOBALS["a_stock_items"]->Stock_Number->FormValue);
					$this->Stock_Item->setSessionValue($this->Stock_Item->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "a_stock_items") {
				if ($this->Stock_Item->CurrentValue == "") $this->Stock_Item->setSessionValue("");
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

		// $url = ew_CurrentUrl(); // <-- removed since v11.0.4
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($view_sales_details_list)) $view_sales_details_list = new cview_sales_details_list();

// Page init
$view_sales_details_list->Page_Init();

// Page main
$view_sales_details_list->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$view_sales_details_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($view_sales_details->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fview_sales_detailslist = new ew_Form("fview_sales_detailslist", "list");
fview_sales_detailslist.FormKeyCountName = '<?php echo $view_sales_details_list->FormKeyCountName ?>';

// Form_CustomValidate event
fview_sales_detailslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fview_sales_detailslist.ValidateRequired = true;
<?php } else { ?>
fview_sales_detailslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fview_sales_detailslist.Lists["x_Supplier_Number"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":["x_Stock_Item"],"FilterFields":[],"Options":[],"Template":""};
fview_sales_detailslist.Lists["x_Stock_Item"] = {"LinkField":"x_Stock_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Stock_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
var CurrentSearchForm = fview_sales_detailslistsrch = new ew_Form("fview_sales_detailslistsrch");

// Init search panel as collapsed
<?php if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_COLLAPSED) { ?>
if (fview_sales_detailslistsrch) fview_sales_detailslistsrch.InitSearchPanel = true;
<?php } else { ?>
<?php if (MS_SEARCH_PANEL_COLLAPSED == TRUE && CurrentPage()->SearchWhere == "") { ?>
if (fview_sales_detailslistsrch) fview_sales_detailslistsrch.InitSearchPanel = true;
<?php } elseif ( (MS_SEARCH_PANEL_COLLAPSED == TRUE && CurrentPage()->SearchWhere <> "") || (MS_SEARCH_PANEL_COLLAPSED == FALSE && CurrentPage()->SearchWhere == "") ) { ?>
if (fview_sales_detailslistsrch) fview_sales_detailslistsrch.InitSearchPanel = false;
<?php } ?>
<?php } ?>
</script>
<script type="text/javascript" src="phpjs/ewscrolltable.min.js"></script>
<style type="text/css">
.ewTablePreviewRow { /* main table preview row color */
	background-color: #FFFFFF; /* preview row color */
}
.ewTablePreviewRow .ewGrid {
	display: table;
}
.ewTablePreviewRow .ewGrid .ewTable {
	width: auto;
}
</style>
<div id="ewPreview" class="hide"><ul class="nav nav-tabs"></ul><div class="tab-content"><div class="tab-pane fade"></div></div></div>
<script type="text/javascript" src="phpjs/ewpreview.min.js"></script>
<script type="text/javascript">
var EW_PREVIEW_PLACEMENT = EW_CSS_FLIP ? "left" : "right";
var EW_PREVIEW_SINGLE_ROW = false;
var EW_PREVIEW_OVERLAY = false;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($view_sales_details->Export == "") { ?>
<?php $bShowLangSelector = false; ?>
<div class="ewToolbar">
<?php if ($view_sales_details->Export == "") { ?>
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php } ?>
<?php if ($view_sales_details_list->TotalRecs > 0 && $view_sales_details->getCurrentMasterTable() == "" && $view_sales_details_list->ExportOptions->Visible()) { ?>
<?php $view_sales_details_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if (($view_sales_details->Export == "") || (EW_EXPORT_MASTER_RECORD && $view_sales_details->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "a_stock_itemslist.php";
if ($view_sales_details_list->DbMasterFilter <> "" && $view_sales_details->getCurrentMasterTable() == "a_stock_items") {
	if ($view_sales_details_list->MasterRecordExists) {
		if ($view_sales_details->getCurrentMasterTable() == $view_sales_details->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($view_sales_details_list->ExportOptions->Visible()) { ?>
<?php $view_sales_details_list->ExportOptions->Render("body") ?> 
<?php } ?>
<?php if ($view_sales_details_list->SearchOptions->Visible()) { ?>
<?php $view_sales_details_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($view_sales_details_list->FilterOptions->Visible()) { ?>
<?php $view_sales_details_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($view_sales_details->Export == "") { ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<?php $bShowLangSelector = true; ?>
<?php if ($view_sales_details->Export == "") { ?>
<div class="phpmaker"><a href="<?php echo $gsMasterReturnUrl ?>" class="BackToMasterRecordPage"><?php echo $Language->Phrase("BackToMasterRecordPage") ?></a></div>
<?php } ?>
<?php include_once "a_stock_itemsmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php if ($bShowLangSelector == false) { ?>
<?php if ($view_sales_details_list->SearchOptions->Visible()) { ?>
<?php $view_sales_details_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($view_sales_details_list->FilterOptions->Visible()) { ?>
<?php $view_sales_details_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($view_sales_details->Export == "") { ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php // movedown htmmaster session to htmheader session in template ?>
<?php
	$bSelectLimit = $view_sales_details_list->UseSelectLimit;
	if ($bSelectLimit) { // begin of v11.0.4
		if ($view_sales_details_list->TotalRecs <= 0)
			$view_sales_details_list->TotalRecs = $view_sales_details->SelectRecordCount();
	} else {
		if (!$view_sales_details_list->Recordset && ($view_sales_details_list->Recordset = $view_sales_details_list->LoadRecordset()))
			$view_sales_details_list->TotalRecs = $view_sales_details_list->Recordset->RecordCount();
	} // end of v11.0.4
	$view_sales_details_list->StartRec = 1;

// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012     
    if ($view_sales_details_list->DisplayRecs <= 0 || ($view_sales_details->Export <> "" && $view_sales_details->ExportAll=="allpages")) // Display all records
        $view_sales_details_list->DisplayRecs = $view_sales_details_list->TotalRecs;
    if (!($view_sales_details->Export <> "" && $view_sales_details->ExportAll=="allpages"))
        $view_sales_details_list->SetUpStartRec(); // Set up start record position

// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
	if ($bSelectLimit)
		$view_sales_details_list->Recordset = $view_sales_details_list->LoadRecordset($view_sales_details_list->StartRec-1, $view_sales_details_list->DisplayRecs);

	// Set no record found message
	if ($view_sales_details->CurrentAction == "" && $view_sales_details_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$view_sales_details_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($view_sales_details_list->SearchWhere == "0=101")
			$view_sales_details_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$view_sales_details_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$view_sales_details_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($view_sales_details->Export == "" && $view_sales_details->CurrentAction == "") { ?>
<form name="fview_sales_detailslistsrch" id="fview_sales_detailslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($view_sales_details_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fview_sales_detailslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_sales_details">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($view_sales_details_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($view_sales_details_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $view_sales_details_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($view_sales_details_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($view_sales_details_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($view_sales_details_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($view_sales_details_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $view_sales_details_list->ShowPageHeader(); ?>
<?php
$view_sales_details_list->ShowMessage();
?>
<?php //////////////////////////// BEGIN Empty Table ?>
<?php // Begin of modification Displaying Empty Table, by Masino Sinaga, May 3, 2012 ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE) { ?>
<?php if ($view_sales_details_list->TotalRecs == 0) { ?>
<div class="panel panel-default ewGrid">
<?php if (MS_PAGINATION_POSITION == 1 || MS_PAGINATION_POSITION == 3) { ?>
<div class="panel-heading ewGridUpperPanel" style="height: 40px;">
<?php if ($view_sales_details_list->TotalRecs == 0 && $view_sales_details->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($view_sales_details_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div class="clearfix"></div><div class="ewPager"></div>
</div>
<?php } ?>
<div id="gmp_view_sales_details_empty_table" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_view_sales_detailslist" class="table ewTable">
<?php echo $view_sales_details->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($view_sales_details->Sales_Number->Visible) { // Sales_Number ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Sales_Number) == "") { ?>
		<th data-name="Sales_Number"><div id="elh_view_sales_details_Sales_Number" class="view_sales_details_Sales_Number"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Number"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Sales_Number) ?>',1);"><div id="elh_view_sales_details_Sales_Number" class="view_sales_details_Sales_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Sales_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Sales_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Supplier_Number->Visible) { // Supplier_Number ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Supplier_Number) == "") { ?>
		<th data-name="Supplier_Number"><div id="elh_view_sales_details_Supplier_Number" class="view_sales_details_Supplier_Number"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Supplier_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Supplier_Number"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Supplier_Number) ?>',1);"><div id="elh_view_sales_details_Supplier_Number" class="view_sales_details_Supplier_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Supplier_Number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Supplier_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Supplier_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Stock_Item->Visible) { // Stock_Item ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Stock_Item) == "") { ?>
		<th data-name="Stock_Item"><div id="elh_view_sales_details_Stock_Item" class="view_sales_details_Stock_Item"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Stock_Item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Stock_Item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Stock_Item) ?>',1);"><div id="elh_view_sales_details_Stock_Item" class="view_sales_details_Stock_Item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Stock_Item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Stock_Item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Stock_Item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Sales_Quantity->Visible) { // Sales_Quantity ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Sales_Quantity) == "") { ?>
		<th data-name="Sales_Quantity"><div id="elh_view_sales_details_Sales_Quantity" class="view_sales_details_Sales_Quantity"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Quantity->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Quantity"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Sales_Quantity) ?>',1);"><div id="elh_view_sales_details_Sales_Quantity" class="view_sales_details_Sales_Quantity">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Quantity->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Sales_Quantity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Sales_Quantity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Purchasing_Price->Visible) { // Purchasing_Price ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Purchasing_Price) == "") { ?>
		<th data-name="Purchasing_Price"><div id="elh_view_sales_details_Purchasing_Price" class="view_sales_details_Purchasing_Price"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Purchasing_Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Purchasing_Price"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Purchasing_Price) ?>',1);"><div id="elh_view_sales_details_Purchasing_Price" class="view_sales_details_Purchasing_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Purchasing_Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Purchasing_Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Purchasing_Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Sales_Price->Visible) { // Sales_Price ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Sales_Price) == "") { ?>
		<th data-name="Sales_Price"><div id="elh_view_sales_details_Sales_Price" class="view_sales_details_Sales_Price"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Price"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Sales_Price) ?>',1);"><div id="elh_view_sales_details_Sales_Price" class="view_sales_details_Sales_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Sales_Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Sales_Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Sales_Total_Amount) == "") { ?>
		<th data-name="Sales_Total_Amount"><div id="elh_view_sales_details_Sales_Total_Amount" class="view_sales_details_Sales_Total_Amount"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Total_Amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Total_Amount"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Sales_Total_Amount) ?>',1);"><div id="elh_view_sales_details_Sales_Total_Amount" class="view_sales_details_Sales_Total_Amount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Total_Amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Sales_Total_Amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Sales_Total_Amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
	</tr>
</thead>
<tbody>
	<tr<?php echo $view_sales_details->RowAttributes() ?>>
	<?php if ($view_sales_details->Sales_Number->Visible) { // Sales_Number ?>
		<td data-name="Sales_Number"<?php echo $view_sales_details->Sales_Number->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Sales_Number" class="view_sales_details_Sales_Number">
<span<?php echo $view_sales_details->Sales_Number->ViewAttributes() ?>>
<?php echo $view_sales_details->Sales_Number->ListViewValue() ?></span>
</span>
<a id="<?php echo $view_sales_details_list->PageObjName . "_row_" . $view_sales_details_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($view_sales_details->Supplier_Number->Visible) { // Supplier_Number ?>
		<td data-name="Supplier_Number"<?php echo $view_sales_details->Supplier_Number->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Supplier_Number" class="view_sales_details_Supplier_Number">
<span<?php echo $view_sales_details->Supplier_Number->ViewAttributes() ?>>
<?php echo $view_sales_details->Supplier_Number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Stock_Item->Visible) { // Stock_Item ?>
		<td data-name="Stock_Item"<?php echo $view_sales_details->Stock_Item->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Stock_Item" class="view_sales_details_Stock_Item">
<span<?php echo $view_sales_details->Stock_Item->ViewAttributes() ?>>
<?php echo $view_sales_details->Stock_Item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Quantity->Visible) { // Sales_Quantity ?>
		<td data-name="Sales_Quantity"<?php echo $view_sales_details->Sales_Quantity->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Sales_Quantity" class="view_sales_details_Sales_Quantity">
<span<?php echo $view_sales_details->Sales_Quantity->ViewAttributes() ?>>
<?php echo $view_sales_details->Sales_Quantity->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Purchasing_Price->Visible) { // Purchasing_Price ?>
		<td data-name="Purchasing_Price"<?php echo $view_sales_details->Purchasing_Price->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Purchasing_Price" class="view_sales_details_Purchasing_Price">
<span<?php echo $view_sales_details->Purchasing_Price->ViewAttributes() ?>>
<?php echo $view_sales_details->Purchasing_Price->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Price->Visible) { // Sales_Price ?>
		<td data-name="Sales_Price"<?php echo $view_sales_details->Sales_Price->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Sales_Price" class="view_sales_details_Sales_Price">
<span<?php echo $view_sales_details->Sales_Price->ViewAttributes() ?>>
<?php echo $view_sales_details->Sales_Price->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
		<td data-name="Sales_Total_Amount"<?php echo $view_sales_details->Sales_Total_Amount->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Sales_Total_Amount" class="view_sales_details_Sales_Total_Amount">
<span<?php echo $view_sales_details->Sales_Total_Amount->ViewAttributes() ?>>
<?php echo $view_sales_details->Sales_Total_Amount->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	</tr>
</tbody>
<tfoot><!-- Table footer -->
	<tr class="ewTableFooter">
	<?php if ($view_sales_details->Sales_Number->Visible) { // Sales_Number ?>
		<td data-name="Sales_Number"><span id="elf_view_sales_details_Sales_Number" class="view_sales_details_Sales_Number">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Supplier_Number->Visible) { // Supplier_Number ?>
		<td data-name="Supplier_Number"><span id="elf_view_sales_details_Supplier_Number" class="view_sales_details_Supplier_Number">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Stock_Item->Visible) { // Stock_Item ?>
		<td data-name="Stock_Item"><span id="elf_view_sales_details_Stock_Item" class="view_sales_details_Stock_Item">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Quantity->Visible) { // Sales_Quantity ?>
		<td data-name="Sales_Quantity"><span id="elf_view_sales_details_Sales_Quantity" class="view_sales_details_Sales_Quantity">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?></span>
<?php echo $view_sales_details->Sales_Quantity->ViewValue ?>
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Purchasing_Price->Visible) { // Purchasing_Price ?>
		<td data-name="Purchasing_Price"><span id="elf_view_sales_details_Purchasing_Price" class="view_sales_details_Purchasing_Price">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Price->Visible) { // Sales_Price ?>
		<td data-name="Sales_Price"><span id="elf_view_sales_details_Sales_Price" class="view_sales_details_Sales_Price">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
		<td data-name="Sales_Total_Amount"><span id="elf_view_sales_details_Sales_Total_Amount" class="view_sales_details_Sales_Total_Amount">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?></span>
<?php echo $view_sales_details->Sales_Total_Amount->ViewValue ?>
		</span></td>
	<?php } ?>
	</tr>
</tfoot>
</table>
</div>
<?php if (MS_PAGINATION_POSITION == 2 || MS_PAGINATION_POSITION == 3) { ?>
<div class="panel-footer ewGridLowerPanel" style="height: 40px;">
<?php if ($view_sales_details_list->TotalRecs == 0 && $view_sales_details->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($view_sales_details_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div class="clearfix"></div></div>
<?php } ?>
</div>
<?php } ?>
<?php } ?>
<?php // End of modification Displaying Empty Table, by Masino Sinaga, May 3, 2012 ?>
<?php //////////////////////////// END Empty Table ?>
<?php if ($view_sales_details_list->TotalRecs > 0 || $view_sales_details->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<?php if ($view_sales_details->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($view_sales_details->CurrentAction <> "gridadd" && $view_sales_details->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if ($view_sales_details_list->TotalRecs > 0) { ?>
<?php if ( (MS_SELECTABLE_PAGE_SIZES_POSITION=="Left" && $Language->Phrase("dir")!="rtl") || (MS_SELECTABLE_PAGE_SIZES_POSITION=="Left" && $Language->Phrase("dir")=="rtl") ) { ?>
<div class="ewPager"><span>&nbsp;<?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</span>
<input type="hidden" name="t" value="view_sales_details">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<?php $sRecPerPageList = explode(',', MS_TABLE_SELECTABLE_REC_PER_PAGE_LIST); ?>
<?php
foreach ($sRecPerPageList as $a) {
 $thisDisplayRecs = $a;
 if ($thisDisplayRecs > 0 ) {
   $thisValue = $thisDisplayRecs;  
?>
<option value="<?php echo $thisDisplayRecs; ?>"<?php if ($view_sales_details_list->DisplayRecs == $thisValue) { ?> selected="selected"<?php } ?>><?php echo $thisDisplayRecs; ?></option>
<?php	} else { ?>
<option value="ALL"<?php if ($view_sales_details->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
<?php
		}
	}
?>
</select>
</div>
<?php } ?>
<?php } ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($view_sales_details_list->Pager)) $view_sales_details_list->Pager = new cNumericPager($view_sales_details_list->StartRec, $view_sales_details_list->DisplayRecs, $view_sales_details_list->TotalRecs, $view_sales_details_list->RecRange) ?>
		<?php if ($view_sales_details_list->Pager->RecordCount > 0) { ?>
				<?php if (($view_sales_details_list->Pager->PageCount==1) && ($view_sales_details_list->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($view_sales_details_list->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($view_sales_details_list->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($view_sales_details_list->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $view_sales_details_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($view_sales_details_list->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($view_sales_details_list->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $view_sales_details_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $view_sales_details_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $view_sales_details_list->Pager->RecordCount ?></span>
				</div>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($view_sales_details_list->Pager)) $view_sales_details_list->Pager = new cPrevNextPager($view_sales_details_list->StartRec, $view_sales_details_list->DisplayRecs, $view_sales_details_list->TotalRecs) ?>
		<?php if ($view_sales_details_list->Pager->RecordCount > 0) { ?>
				<?php if (($view_sales_details_list->Pager->PageCount==1) && ($view_sales_details_list->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($view_sales_details_list->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($view_sales_details_list->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $view_sales_details_list->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($view_sales_details_list->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($view_sales_details_list->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $view_sales_details_list->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $view_sales_details_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $view_sales_details_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $view_sales_details_list->Pager->RecordCount ?></span>
				</div>
		<?php } ?>
	<?php } // end of link or button ?>	
<?php if ($view_sales_details_list->TotalRecs > 0) { ?>
<?php if ( (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right" && $Language->Phrase("dir")!="rtl") || (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right" && $Language->Phrase("dir")=="rtl") ) { ?>
<div class="ewPager"><span>&nbsp;<?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</span>
<input type="hidden" name="t" value="view_sales_details">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="1"<?php if ($view_sales_details_list->DisplayRecs == 1) { ?> selected="selected"<?php } ?>>1</option>
<option value="3"<?php if ($view_sales_details_list->DisplayRecs == 3) { ?> selected="selected"<?php } ?>>3</option>
<option value="5"<?php if ($view_sales_details_list->DisplayRecs == 5) { ?> selected="selected"<?php } ?>>5</option>
<option value="10"<?php if ($view_sales_details_list->DisplayRecs == 10) { ?> selected="selected"<?php } ?>>10</option>
<option value="20"<?php if ($view_sales_details_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($view_sales_details_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($view_sales_details_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
</select>
</div>
<?php } // end if (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right") ?>
<?php } // end TotalRecs ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($view_sales_details_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fview_sales_detailslist" id="fview_sales_detailslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($view_sales_details_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $view_sales_details_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="view_sales_details">
<?php // Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012 ?>
<?php if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") { ?>
<input type="hidden" name="exporttype" id="exporttype" value="">
<?php } ?>
<?php // End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012 ?>
<?php if ($view_sales_details->getCurrentMasterTable() == "a_stock_items" && $view_sales_details->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="a_stock_items">
<input type="hidden" name="fk_Stock_Number" value="<?php echo $view_sales_details->Stock_Item->getSessionValue() ?>">
<?php } ?>
<div id="gmp_view_sales_details" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($view_sales_details_list->TotalRecs > 0) { ?>
<table id="tbl_view_sales_detailslist" class="table ewTable">
<?php echo $view_sales_details->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$view_sales_details_list->RowType = EW_ROWTYPE_HEADER; // since v11.0.6

// Render list options
$view_sales_details_list->RenderListOptions();

// Render list options (header, left)
$view_sales_details_list->ListOptions->Render("header", "left");
?>
<?php if ($view_sales_details->Sales_Number->Visible) { // Sales_Number ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Sales_Number) == "") { ?>
		<th data-name="Sales_Number"><div id="elh_view_sales_details_Sales_Number" class="view_sales_details_Sales_Number"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Number"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Sales_Number) ?>',1);"><div id="elh_view_sales_details_Sales_Number" class="view_sales_details_Sales_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Sales_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Sales_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Supplier_Number->Visible) { // Supplier_Number ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Supplier_Number) == "") { ?>
		<th data-name="Supplier_Number"><div id="elh_view_sales_details_Supplier_Number" class="view_sales_details_Supplier_Number"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Supplier_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Supplier_Number"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Supplier_Number) ?>',1);"><div id="elh_view_sales_details_Supplier_Number" class="view_sales_details_Supplier_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Supplier_Number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Supplier_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Supplier_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Stock_Item->Visible) { // Stock_Item ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Stock_Item) == "") { ?>
		<th data-name="Stock_Item"><div id="elh_view_sales_details_Stock_Item" class="view_sales_details_Stock_Item"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Stock_Item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Stock_Item"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Stock_Item) ?>',1);"><div id="elh_view_sales_details_Stock_Item" class="view_sales_details_Stock_Item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Stock_Item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Stock_Item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Stock_Item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Sales_Quantity->Visible) { // Sales_Quantity ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Sales_Quantity) == "") { ?>
		<th data-name="Sales_Quantity"><div id="elh_view_sales_details_Sales_Quantity" class="view_sales_details_Sales_Quantity"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Quantity->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Quantity"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Sales_Quantity) ?>',1);"><div id="elh_view_sales_details_Sales_Quantity" class="view_sales_details_Sales_Quantity">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Quantity->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Sales_Quantity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Sales_Quantity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Purchasing_Price->Visible) { // Purchasing_Price ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Purchasing_Price) == "") { ?>
		<th data-name="Purchasing_Price"><div id="elh_view_sales_details_Purchasing_Price" class="view_sales_details_Purchasing_Price"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Purchasing_Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Purchasing_Price"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Purchasing_Price) ?>',1);"><div id="elh_view_sales_details_Purchasing_Price" class="view_sales_details_Purchasing_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Purchasing_Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Purchasing_Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Purchasing_Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Sales_Price->Visible) { // Sales_Price ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Sales_Price) == "") { ?>
		<th data-name="Sales_Price"><div id="elh_view_sales_details_Sales_Price" class="view_sales_details_Sales_Price"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Price"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Sales_Price) ?>',1);"><div id="elh_view_sales_details_Sales_Price" class="view_sales_details_Sales_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Sales_Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Sales_Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($view_sales_details->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
	<?php if ($view_sales_details->SortUrl($view_sales_details->Sales_Total_Amount) == "") { ?>
		<th data-name="Sales_Total_Amount"><div id="elh_view_sales_details_Sales_Total_Amount" class="view_sales_details_Sales_Total_Amount"><div class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Total_Amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Total_Amount"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $view_sales_details->SortUrl($view_sales_details->Sales_Total_Amount) ?>',1);"><div id="elh_view_sales_details_Sales_Total_Amount" class="view_sales_details_Sales_Total_Amount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $view_sales_details->Sales_Total_Amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($view_sales_details->Sales_Total_Amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($view_sales_details->Sales_Total_Amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$view_sales_details_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php

// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
if ($view_sales_details->ExportAll=="allpages" && $view_sales_details->Export <> "") {
    $view_sales_details_list->StopRec = $view_sales_details_list->TotalRecs;

// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
} else {

	// Set the last record to display
	if ($view_sales_details_list->TotalRecs > $view_sales_details_list->StartRec + $view_sales_details_list->DisplayRecs - 1)
		$view_sales_details_list->StopRec = $view_sales_details_list->StartRec + $view_sales_details_list->DisplayRecs - 1;
	else
		$view_sales_details_list->StopRec = $view_sales_details_list->TotalRecs;
}
$view_sales_details_list->RecCnt = $view_sales_details_list->StartRec - 1;
if ($view_sales_details_list->Recordset && !$view_sales_details_list->Recordset->EOF) {
	$view_sales_details_list->Recordset->MoveFirst();
	$bSelectLimit = $view_sales_details_list->UseSelectLimit;
	if (!$bSelectLimit && $view_sales_details_list->StartRec > 1)
		$view_sales_details_list->Recordset->Move($view_sales_details_list->StartRec - 1);
} elseif (!$view_sales_details->AllowAddDeleteRow && $view_sales_details_list->StopRec == 0) {
	$view_sales_details_list->StopRec = $view_sales_details->GridAddRowCount;
}

// Initialize aggregate
$view_sales_details->RowType = EW_ROWTYPE_AGGREGATEINIT;
$view_sales_details->ResetAttrs();
$view_sales_details_list->RenderRow();
while ($view_sales_details_list->RecCnt < $view_sales_details_list->StopRec) {
	$view_sales_details_list->RecCnt++;
	if (intval($view_sales_details_list->RecCnt) >= intval($view_sales_details_list->StartRec)) {
		$view_sales_details_list->RowCnt++;

		// Set up key count
		$view_sales_details_list->KeyCount = $view_sales_details_list->RowIndex;

		// Init row class and style
		$view_sales_details->ResetAttrs();
		$view_sales_details->CssClass = "";
		if ($view_sales_details->CurrentAction == "gridadd") {
		} else {
			$view_sales_details_list->LoadRowValues($view_sales_details_list->Recordset); // Load row values
		}
		$view_sales_details->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$view_sales_details->RowAttrs = array_merge($view_sales_details->RowAttrs, array('data-rowindex'=>$view_sales_details_list->RowCnt, 'id'=>'r' . $view_sales_details_list->RowCnt . '_view_sales_details', 'data-rowtype'=>$view_sales_details->RowType));

		// Render row
		$view_sales_details_list->RenderRow();

		// Render list options
		$view_sales_details_list->RenderListOptions();
?>
	<tr<?php echo $view_sales_details->RowAttributes() ?>>
<?php

// Render list options (body, left)
$view_sales_details_list->ListOptions->Render("body", "left", $view_sales_details_list->RowCnt);
?>
	<?php if ($view_sales_details->Sales_Number->Visible) { // Sales_Number ?>
		<td data-name="Sales_Number"<?php echo $view_sales_details->Sales_Number->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Sales_Number" class="view_sales_details_Sales_Number">
<span<?php echo $view_sales_details->Sales_Number->ViewAttributes() ?>>
<?php echo $view_sales_details->Sales_Number->ListViewValue() ?></span>
</span>
<a id="<?php echo $view_sales_details_list->PageObjName . "_row_" . $view_sales_details_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($view_sales_details->Supplier_Number->Visible) { // Supplier_Number ?>
		<td data-name="Supplier_Number"<?php echo $view_sales_details->Supplier_Number->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Supplier_Number" class="view_sales_details_Supplier_Number">
<span<?php echo $view_sales_details->Supplier_Number->ViewAttributes() ?>>
<?php echo $view_sales_details->Supplier_Number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Stock_Item->Visible) { // Stock_Item ?>
		<td data-name="Stock_Item"<?php echo $view_sales_details->Stock_Item->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Stock_Item" class="view_sales_details_Stock_Item">
<span<?php echo $view_sales_details->Stock_Item->ViewAttributes() ?>>
<?php echo $view_sales_details->Stock_Item->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Quantity->Visible) { // Sales_Quantity ?>
		<td data-name="Sales_Quantity"<?php echo $view_sales_details->Sales_Quantity->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Sales_Quantity" class="view_sales_details_Sales_Quantity">
<span<?php echo $view_sales_details->Sales_Quantity->ViewAttributes() ?>>
<?php echo $view_sales_details->Sales_Quantity->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Purchasing_Price->Visible) { // Purchasing_Price ?>
		<td data-name="Purchasing_Price"<?php echo $view_sales_details->Purchasing_Price->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Purchasing_Price" class="view_sales_details_Purchasing_Price">
<span<?php echo $view_sales_details->Purchasing_Price->ViewAttributes() ?>>
<?php echo $view_sales_details->Purchasing_Price->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Price->Visible) { // Sales_Price ?>
		<td data-name="Sales_Price"<?php echo $view_sales_details->Sales_Price->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Sales_Price" class="view_sales_details_Sales_Price">
<span<?php echo $view_sales_details->Sales_Price->ViewAttributes() ?>>
<?php echo $view_sales_details->Sales_Price->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
		<td data-name="Sales_Total_Amount"<?php echo $view_sales_details->Sales_Total_Amount->CellAttributes() ?>>
<span id="el<?php echo $view_sales_details_list->RowCnt ?>_view_sales_details_Sales_Total_Amount" class="view_sales_details_Sales_Total_Amount">
<span<?php echo $view_sales_details->Sales_Total_Amount->ViewAttributes() ?>>
<?php echo $view_sales_details->Sales_Total_Amount->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$view_sales_details_list->ListOptions->Render("body", "right", $view_sales_details_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($view_sales_details->CurrentAction <> "gridadd")
		$view_sales_details_list->Recordset->MoveNext();
}
?>
</tbody>
<?php

// Render aggregate row
$view_sales_details->RowType = EW_ROWTYPE_AGGREGATE;
$view_sales_details->ResetAttrs();
$view_sales_details_list->RenderRow();
?>
<?php if ($view_sales_details_list->TotalRecs > 0 && ($view_sales_details->CurrentAction <> "gridadd" && $view_sales_details->CurrentAction <> "gridedit")) { ?>
<tfoot><!-- Table footer -->
	<tr class="ewTableFooter">
<?php

// Render list options
$view_sales_details_list->RenderListOptions();

// Render list options (footer, left)
$view_sales_details_list->ListOptions->Render("footer", "left");
?>
	<?php if ($view_sales_details->Sales_Number->Visible) { // Sales_Number ?>
		<td data-name="Sales_Number"><span id="elf_view_sales_details_Sales_Number" class="view_sales_details_Sales_Number">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Supplier_Number->Visible) { // Supplier_Number ?>
		<td data-name="Supplier_Number"><span id="elf_view_sales_details_Supplier_Number" class="view_sales_details_Supplier_Number">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Stock_Item->Visible) { // Stock_Item ?>
		<td data-name="Stock_Item"><span id="elf_view_sales_details_Stock_Item" class="view_sales_details_Stock_Item">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Quantity->Visible) { // Sales_Quantity ?>
		<td data-name="Sales_Quantity"><span id="elf_view_sales_details_Sales_Quantity" class="view_sales_details_Sales_Quantity">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?></span>
<?php echo $view_sales_details->Sales_Quantity->ViewValue ?>
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Purchasing_Price->Visible) { // Purchasing_Price ?>
		<td data-name="Purchasing_Price"><span id="elf_view_sales_details_Purchasing_Price" class="view_sales_details_Purchasing_Price">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Price->Visible) { // Sales_Price ?>
		<td data-name="Sales_Price"><span id="elf_view_sales_details_Sales_Price" class="view_sales_details_Sales_Price">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($view_sales_details->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
		<td data-name="Sales_Total_Amount"><span id="elf_view_sales_details_Sales_Total_Amount" class="view_sales_details_Sales_Total_Amount">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?></span>
<?php echo $view_sales_details->Sales_Total_Amount->ViewValue ?>
		</span></td>
	<?php } ?>
<?php

// Render list options (footer, right)
$view_sales_details_list->ListOptions->Render("footer", "right");
?>
	</tr>
</tfoot>	
<?php } ?>
</table>
<?php } ?>
<?php if ($view_sales_details->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($view_sales_details_list->Recordset)
	$view_sales_details_list->Recordset->Close();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
<?php if ($view_sales_details->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($view_sales_details->CurrentAction <> "gridadd" && $view_sales_details->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if ($view_sales_details_list->TotalRecs > 0) { ?>
<?php if ( (MS_SELECTABLE_PAGE_SIZES_POSITION=="Left" && $Language->Phrase("dir")!="rtl") || (MS_SELECTABLE_PAGE_SIZES_POSITION=="Left" && $Language->Phrase("dir")=="rtl") ) { ?>
<div class="ewPager"><span>&nbsp;<?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</span>
<input type="hidden" name="t" value="view_sales_details">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<?php $sRecPerPageList = explode(',', MS_TABLE_SELECTABLE_REC_PER_PAGE_LIST); ?>
<?php
foreach ($sRecPerPageList as $a) {
 $thisDisplayRecs = $a;
 if ($thisDisplayRecs > 0 ) {
   $thisValue = $thisDisplayRecs;  
?>
<option value="<?php echo $thisDisplayRecs; ?>"<?php if ($view_sales_details_list->DisplayRecs == $thisValue) { ?> selected="selected"<?php } ?>><?php echo $thisDisplayRecs; ?></option>
<?php	} else { ?>
<option value="ALL"<?php if ($view_sales_details->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
<?php
		}
	}
?>
</select>
</div>
<?php } ?>
<?php } ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($view_sales_details_list->Pager)) $view_sales_details_list->Pager = new cNumericPager($view_sales_details_list->StartRec, $view_sales_details_list->DisplayRecs, $view_sales_details_list->TotalRecs, $view_sales_details_list->RecRange) ?>
		<?php if ($view_sales_details_list->Pager->RecordCount > 0) { ?>
				<?php if (($view_sales_details_list->Pager->PageCount==1) && ($view_sales_details_list->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($view_sales_details_list->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($view_sales_details_list->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($view_sales_details_list->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $view_sales_details_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($view_sales_details_list->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($view_sales_details_list->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $view_sales_details_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $view_sales_details_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $view_sales_details_list->Pager->RecordCount ?></span>
				</div>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($view_sales_details_list->Pager)) $view_sales_details_list->Pager = new cPrevNextPager($view_sales_details_list->StartRec, $view_sales_details_list->DisplayRecs, $view_sales_details_list->TotalRecs) ?>
		<?php if ($view_sales_details_list->Pager->RecordCount > 0) { ?>
				<?php if (($view_sales_details_list->Pager->PageCount==1) && ($view_sales_details_list->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($view_sales_details_list->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($view_sales_details_list->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $view_sales_details_list->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($view_sales_details_list->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($view_sales_details_list->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $view_sales_details_list->PageUrl() ?>start=<?php echo $view_sales_details_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $view_sales_details_list->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $view_sales_details_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $view_sales_details_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $view_sales_details_list->Pager->RecordCount ?></span>
				</div>
		<?php } ?>
	<?php } // end of link or button ?>	
<?php if ($view_sales_details_list->TotalRecs > 0) { ?>
<?php if ( (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right" && $Language->Phrase("dir")!="rtl") || (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right" && $Language->Phrase("dir")=="rtl") ) { ?>
<div class="ewPager"><span>&nbsp;<?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</span>
<input type="hidden" name="t" value="view_sales_details">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="1"<?php if ($view_sales_details_list->DisplayRecs == 1) { ?> selected="selected"<?php } ?>>1</option>
<option value="3"<?php if ($view_sales_details_list->DisplayRecs == 3) { ?> selected="selected"<?php } ?>>3</option>
<option value="5"<?php if ($view_sales_details_list->DisplayRecs == 5) { ?> selected="selected"<?php } ?>>5</option>
<option value="10"<?php if ($view_sales_details_list->DisplayRecs == 10) { ?> selected="selected"<?php } ?>>10</option>
<option value="20"<?php if ($view_sales_details_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($view_sales_details_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($view_sales_details_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
</select>
</div>
<?php } // end if (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right") ?>
<?php } // end TotalRecs ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($view_sales_details_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
</div>
<?php } ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE==FALSE) { ?>
<?php if ($view_sales_details_list->TotalRecs == 0 && $view_sales_details->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($view_sales_details_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php } // MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE is false ?>
<?php if ($view_sales_details->Export == "") { ?>
<script type="text/javascript">
fview_sales_detailslistsrch.Init();
fview_sales_detailslistsrch.FilterList = <?php echo $view_sales_details_list->GetFilterList() ?>;
fview_sales_detailslist.Init();
</script>
<?php } ?>
<?php
$view_sales_details_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($view_sales_details->Export == "") { ?>
<script type="text/javascript">
$(document).ready(function() {
	$("td:has(.ewAggregate)").css({"text-align": "right", "font-weight": "bold"}).find(".ewAggregate").hide();	
});
$(document).on("preview", function(e, args) {
	var $tabpane = args.$tabpane;
	$tabpane.find("td:has(.ewAggregate)").css({"text-align": "right", "font-weight": "bold"}).find(".ewAggregate").hide();
});
</script>
<?php if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_COLLAPSED) { ?>
<?php if (isset($_SESSION['table_view_sales_details_views']) && $_SESSION['table_view_sales_details_views'] == 1) { ?>
	<?php if (CurrentPage()->SearchPanelCollapsed==FALSE) { ?>
<script type="text/javascript">
$(document).ready(function() {
	var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel');
	SearchPanel.addClass('in'); SearchToggle.addClass('active');
});
</script>
	<?php } elseif (CurrentPage()->SearchPanelCollapsed==TRUE) { ?>
<script type="text/javascript">
$(document).ready(function() {
	var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel');
	SearchPanel.removeClass('in'); SearchToggle.removeClass('active');
});
</script>	
	<?php } ?>
<?php } else { ?>
<?php if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_STATUS==TRUE && MS_USE_PHPMAKER_SETTING_FOR_INITIATE_SEARCH_PANEL==TRUE) { ?>
<script type="text/javascript">
$(document).ready(function() { var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel'); if(getCookie('view_sales_details_searchpanel')=="active"){ SearchToggle.addClass(getCookie('view_sales_details_searchpanel')); SearchPanel.addClass('in'); SearchToggle.addClass('active'); }else{ SearchPanel.removeClass('in'); SearchToggle.removeClass('active'); } SearchToggle.on('click',function(event) { event.preventDefault(); if (SearchToggle.hasClass('active')){ createCookie("view_sales_details_searchpanel", "notactive", 1); }else{ createCookie("view_sales_details_searchpanel", "active", 1); } }); });
</script>
<?php } elseif (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_STATUS==TRUE && MS_USE_PHPMAKER_SETTING_FOR_INITIATE_SEARCH_PANEL==FALSE) { ?>
<script type="text/javascript">
$(document).ready(function() { var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel'); if(getCookie('view_sales_details_searchpanel')=="active"){ SearchToggle.addClass(getCookie('view_sales_details_searchpanel')); SearchPanel.addClass('in'); SearchToggle.addClass('active'); }else{ SearchPanel.removeClass('in'); SearchToggle.removeClass('active'); } SearchToggle.on('click',function(event) { event.preventDefault(); if (SearchToggle.hasClass('active')){ createCookie("view_sales_details_searchpanel", "notactive", 1); }else{ createCookie("view_sales_details_searchpanel", "active", 1); } }); });
</script>
<?php } ?>
<?php } ?>
<?php } else { // end of MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_COLLAPSED ?>
<?php if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_STATUS==TRUE && MS_USE_PHPMAKER_SETTING_FOR_INITIATE_SEARCH_PANEL==TRUE) { ?>
	<?php if (isset($_SESSION['table_view_sales_details_views']) && $_SESSION['table_view_sales_details_views'] == 1) { ?>
<script type="text/javascript">
$(document).ready(function() { var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel'); if(getCookie('view_sales_details_searchpanel')=="active"){ SearchToggle.addClass(getCookie('view_sales_details_searchpanel')); SearchPanel.addClass('in'); SearchToggle.addClass('active'); }else{ SearchPanel.removeClass('in'); SearchToggle.removeClass('active'); } SearchToggle.on('click',function(event) { event.preventDefault(); if (SearchToggle.hasClass('active')){ createCookie("view_sales_details_searchpanel", "notactive", 1); }else{ createCookie("view_sales_details_searchpanel", "active", 1); } }); });
</script>
	<?php } ?>
<?php } elseif (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_STATUS==TRUE && MS_USE_PHPMAKER_SETTING_FOR_INITIATE_SEARCH_PANEL==FALSE) { ?>
<script type="text/javascript">
$(document).ready(function() { var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel'); if(getCookie('view_sales_details_searchpanel')=="active"){ SearchToggle.addClass(getCookie('view_sales_details_searchpanel')); SearchPanel.addClass('in'); SearchToggle.addClass('active'); }else{ SearchPanel.removeClass('in'); SearchToggle.removeClass('active'); } SearchToggle.on('click',function(event) { event.preventDefault(); if (SearchToggle.hasClass('active')){ createCookie("view_sales_details_searchpanel", "notactive", 1); }else{ createCookie("view_sales_details_searchpanel", "active", 1); } }); });
</script>
<?php } ?>
<?php } ?>
<?php if (@CurrentPage()->ListOptions->UseDropDownButton == TRUE) { ?>
<?php if (MS_USE_TABLE_SETTING_FOR_DROPUP_LISTOPTIONS == TRUE) { ?>
<script type="text/javascript">
$(document).ready(function() {
	var reccount = <?php echo CurrentPage()->RowCnt; ?>;
	var rowdropup = 4;
	if (reccount > 6) {
		for ( var i = 0; i <= (rowdropup - 1); i++ ) {
			$('#r' + (reccount - i) + '_<?php echo CurrentPage()->TableName; ?> .ewButtonDropdown').addClass('dropup');
		}
	}
});
</script>
<?php } ?>
<?php } ?>
<?php if ($view_sales_details->Export == "") { ?>
<script type="text/javascript">
$('.ewGridSave, .ewGridInsert').attr('onclick', 'return alertifySaveGrid(this)'); function alertifySaveGrid(obj) { <?php global $Language; ?> if (fview_sales_detailslist.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifySaveGridConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifySaveGrid'); ?>"); $("#fview_sales_detailslist").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<script type="text/javascript">
$('.ewInlineUpdate').attr('onclick', 'return alertifySaveInlineEdit(this)'); function alertifySaveInlineEdit(obj) { <?php global $Language; ?> if (fview_sales_detailslist.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifySaveGridConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifySaveGrid'); ?>"); $("#fview_sales_detailslist").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<script type="text/javascript">
$('.ewInlineInsert').attr('onclick', 'return alertifySaveInlineInsert(this)'); function alertifySaveInlineInsert(obj) { <?php global $Language; ?> if (fview_sales_detailslist.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifySaveGridConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifySaveGrid'); ?>"); $("#fview_sales_detailslist").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php if ($view_sales_details->CurrentAction == "" || $view_sales_details->Export == "") { // Change && become || in order to add scroll table in Grid, by Masino Sinaga, August 3, 2014 ?>
<script type="text/javascript">
<?php if (MS_TABLE_WIDTH_STYLE==1) { // Begin of modification Optimizing Main Table Width to Maximum Width of Site, by Masino Sinaga, April 30, 2012 ?>
<?php $iWidthAdjustment = (MS_MENU_HORIZONTAL) ? 0 : 100; ?>
ew_ScrollableTable("gmp_view_sales_details", "<?php echo (MS_SCROLL_TABLE_WIDTH - $iWidthAdjustment); ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_view_sales_details_empty_table", "<?php echo (MS_SCROLL_TABLE_WIDTH - $iWidthAdjustment); ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } elseif (MS_TABLE_WIDTH_STYLE==2) { ?>
ew_ScrollableTable("gmp_view_sales_details", "<?php echo MS_SCROLL_TABLE_WIDTH; ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_view_sales_details_empty_table", "<?php echo MS_SCROLL_TABLE_WIDTH; ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } elseif (MS_TABLE_WIDTH_STYLE==3) { ?>
ew_ScrollableTable("gmp_view_sales_details", "100%", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_view_sales_details_empty_table", "100%", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } // End of modification Optimizing Main Table Width to Maximum Width of Site, by Masino Sinaga, April 30, 2012 ?>
<?php } ?>
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$view_sales_details_list->Page_Terminate();
?>
