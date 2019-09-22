<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "settingsinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$settings_list = NULL; // Initialize page object first

class csettings_list extends csettings {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'settings';

	// Page object name
	var $PageObjName = 'settings_list';

	// Grid form hidden field names
	var $FormName = 'fsettingslist';
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

		// Table object (settings)
		if (!isset($GLOBALS["settings"]) || get_class($GLOBALS["settings"]) == "csettings") {
			$GLOBALS["settings"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["settings"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "settingsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "settingsdelete.php";
		$this->MultiUpdateUrl = "settingsupdate.php";

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'settings', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fsettingslistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm, $UserTableConn;
		if (!isset($_SESSION['table_settings_views'])) { 
			$_SESSION['table_settings_views'] = 0;
		}
		$_SESSION['table_settings_views'] = $_SESSION['table_settings_views']+1;

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
		$this->Option_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $settings;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($settings);
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

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore filter list
			$this->RestoreFilterList();

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
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

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
			$this->Option_ID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Option_ID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Option_ID->AdvancedSearch->ToJSON(), ","); // Field Option_ID
		$sFilterList = ew_Concat($sFilterList, $this->Option_Default->AdvancedSearch->ToJSON(), ","); // Field Option_Default
		$sFilterList = ew_Concat($sFilterList, $this->Default_Theme->AdvancedSearch->ToJSON(), ","); // Field Default_Theme
		$sFilterList = ew_Concat($sFilterList, $this->Font_Name->AdvancedSearch->ToJSON(), ","); // Field Font_Name
		$sFilterList = ew_Concat($sFilterList, $this->Font_Size->AdvancedSearch->ToJSON(), ","); // Field Font_Size
		$sFilterList = ew_Concat($sFilterList, $this->Show_Border_Layout->AdvancedSearch->ToJSON(), ","); // Field Show_Border_Layout
		$sFilterList = ew_Concat($sFilterList, $this->Show_Shadow_Layout->AdvancedSearch->ToJSON(), ","); // Field Show_Shadow_Layout
		$sFilterList = ew_Concat($sFilterList, $this->Menu_Horizontal->AdvancedSearch->ToJSON(), ","); // Field Menu_Horizontal
		$sFilterList = ew_Concat($sFilterList, $this->Vertical_Menu_Width->AdvancedSearch->ToJSON(), ","); // Field Vertical_Menu_Width
		$sFilterList = ew_Concat($sFilterList, $this->Show_Announcement->AdvancedSearch->ToJSON(), ","); // Field Show_Announcement
		$sFilterList = ew_Concat($sFilterList, $this->Demo_Mode->AdvancedSearch->ToJSON(), ","); // Field Demo_Mode
		$sFilterList = ew_Concat($sFilterList, $this->Show_Page_Processing_Time->AdvancedSearch->ToJSON(), ","); // Field Show_Page_Processing_Time
		$sFilterList = ew_Concat($sFilterList, $this->Allow_User_Preferences->AdvancedSearch->ToJSON(), ","); // Field Allow_User_Preferences
		$sFilterList = ew_Concat($sFilterList, $this->SMTP_Server->AdvancedSearch->ToJSON(), ","); // Field SMTP_Server
		$sFilterList = ew_Concat($sFilterList, $this->SMTP_Server_Port->AdvancedSearch->ToJSON(), ","); // Field SMTP_Server_Port
		$sFilterList = ew_Concat($sFilterList, $this->SMTP_Server_Username->AdvancedSearch->ToJSON(), ","); // Field SMTP_Server_Username
		$sFilterList = ew_Concat($sFilterList, $this->SMTP_Server_Password->AdvancedSearch->ToJSON(), ","); // Field SMTP_Server_Password
		$sFilterList = ew_Concat($sFilterList, $this->Sender_Email->AdvancedSearch->ToJSON(), ","); // Field Sender_Email
		$sFilterList = ew_Concat($sFilterList, $this->Recipient_Email->AdvancedSearch->ToJSON(), ","); // Field Recipient_Email
		$sFilterList = ew_Concat($sFilterList, $this->Use_Default_Locale->AdvancedSearch->ToJSON(), ","); // Field Use_Default_Locale
		$sFilterList = ew_Concat($sFilterList, $this->Default_Language->AdvancedSearch->ToJSON(), ","); // Field Default_Language
		$sFilterList = ew_Concat($sFilterList, $this->Default_Timezone->AdvancedSearch->ToJSON(), ","); // Field Default_Timezone
		$sFilterList = ew_Concat($sFilterList, $this->Default_Thousands_Separator->AdvancedSearch->ToJSON(), ","); // Field Default_Thousands_Separator
		$sFilterList = ew_Concat($sFilterList, $this->Default_Decimal_Point->AdvancedSearch->ToJSON(), ","); // Field Default_Decimal_Point
		$sFilterList = ew_Concat($sFilterList, $this->Default_Currency_Symbol->AdvancedSearch->ToJSON(), ","); // Field Default_Currency_Symbol
		$sFilterList = ew_Concat($sFilterList, $this->Default_Money_Thousands_Separator->AdvancedSearch->ToJSON(), ","); // Field Default_Money_Thousands_Separator
		$sFilterList = ew_Concat($sFilterList, $this->Default_Money_Decimal_Point->AdvancedSearch->ToJSON(), ","); // Field Default_Money_Decimal_Point
		$sFilterList = ew_Concat($sFilterList, $this->Maintenance_Mode->AdvancedSearch->ToJSON(), ","); // Field Maintenance_Mode
		$sFilterList = ew_Concat($sFilterList, $this->Maintenance_Finish_DateTime->AdvancedSearch->ToJSON(), ","); // Field Maintenance_Finish_DateTime
		$sFilterList = ew_Concat($sFilterList, $this->Auto_Normal_After_Maintenance->AdvancedSearch->ToJSON(), ","); // Field Auto_Normal_After_Maintenance
		$sFilterList = ew_Concat($sFilterList, $this->Allow_User_To_Register->AdvancedSearch->ToJSON(), ","); // Field Allow_User_To_Register
		$sFilterList = ew_Concat($sFilterList, $this->Suspend_New_User_Account->AdvancedSearch->ToJSON(), ","); // Field Suspend_New_User_Account
		$sFilterList = ew_Concat($sFilterList, $this->User_Need_Activation_After_Registered->AdvancedSearch->ToJSON(), ","); // Field User_Need_Activation_After_Registered
		$sFilterList = ew_Concat($sFilterList, $this->Show_Captcha_On_Registration_Page->AdvancedSearch->ToJSON(), ","); // Field Show_Captcha_On_Registration_Page
		$sFilterList = ew_Concat($sFilterList, $this->Show_Terms_And_Conditions_On_Registration_Page->AdvancedSearch->ToJSON(), ","); // Field Show_Terms_And_Conditions_On_Registration_Page
		$sFilterList = ew_Concat($sFilterList, $this->User_Auto_Login_After_Activation_Or_Registration->AdvancedSearch->ToJSON(), ","); // Field User_Auto_Login_After_Activation_Or_Registration
		$sFilterList = ew_Concat($sFilterList, $this->Show_Captcha_On_Login_Page->AdvancedSearch->ToJSON(), ","); // Field Show_Captcha_On_Login_Page
		$sFilterList = ew_Concat($sFilterList, $this->Show_Captcha_On_Forgot_Password_Page->AdvancedSearch->ToJSON(), ","); // Field Show_Captcha_On_Forgot_Password_Page
		$sFilterList = ew_Concat($sFilterList, $this->Show_Captcha_On_Change_Password_Page->AdvancedSearch->ToJSON(), ","); // Field Show_Captcha_On_Change_Password_Page
		$sFilterList = ew_Concat($sFilterList, $this->User_Auto_Logout_After_Idle_In_Minutes->AdvancedSearch->ToJSON(), ","); // Field User_Auto_Logout_After_Idle_In_Minutes
		$sFilterList = ew_Concat($sFilterList, $this->User_Login_Maximum_Retry->AdvancedSearch->ToJSON(), ","); // Field User_Login_Maximum_Retry
		$sFilterList = ew_Concat($sFilterList, $this->User_Login_Retry_Lockout->AdvancedSearch->ToJSON(), ","); // Field User_Login_Retry_Lockout
		$sFilterList = ew_Concat($sFilterList, $this->Redirect_To_Last_Visited_Page_After_Login->AdvancedSearch->ToJSON(), ","); // Field Redirect_To_Last_Visited_Page_After_Login
		$sFilterList = ew_Concat($sFilterList, $this->Enable_Password_Expiry->AdvancedSearch->ToJSON(), ","); // Field Enable_Password_Expiry
		$sFilterList = ew_Concat($sFilterList, $this->Password_Expiry_In_Days->AdvancedSearch->ToJSON(), ","); // Field Password_Expiry_In_Days
		$sFilterList = ew_Concat($sFilterList, $this->Show_Entire_Header->AdvancedSearch->ToJSON(), ","); // Field Show_Entire_Header
		$sFilterList = ew_Concat($sFilterList, $this->Logo_Width->AdvancedSearch->ToJSON(), ","); // Field Logo_Width
		$sFilterList = ew_Concat($sFilterList, $this->Show_Site_Title_In_Header->AdvancedSearch->ToJSON(), ","); // Field Show_Site_Title_In_Header
		$sFilterList = ew_Concat($sFilterList, $this->Show_Current_User_In_Header->AdvancedSearch->ToJSON(), ","); // Field Show_Current_User_In_Header
		$sFilterList = ew_Concat($sFilterList, $this->Text_Align_In_Header->AdvancedSearch->ToJSON(), ","); // Field Text_Align_In_Header
		$sFilterList = ew_Concat($sFilterList, $this->Site_Title_Text_Style->AdvancedSearch->ToJSON(), ","); // Field Site_Title_Text_Style
		$sFilterList = ew_Concat($sFilterList, $this->Language_Selector_Visibility->AdvancedSearch->ToJSON(), ","); // Field Language_Selector_Visibility
		$sFilterList = ew_Concat($sFilterList, $this->Language_Selector_Align->AdvancedSearch->ToJSON(), ","); // Field Language_Selector_Align
		$sFilterList = ew_Concat($sFilterList, $this->Show_Entire_Footer->AdvancedSearch->ToJSON(), ","); // Field Show_Entire_Footer
		$sFilterList = ew_Concat($sFilterList, $this->Show_Text_In_Footer->AdvancedSearch->ToJSON(), ","); // Field Show_Text_In_Footer
		$sFilterList = ew_Concat($sFilterList, $this->Show_Back_To_Top_On_Footer->AdvancedSearch->ToJSON(), ","); // Field Show_Back_To_Top_On_Footer
		$sFilterList = ew_Concat($sFilterList, $this->Show_Terms_And_Conditions_On_Footer->AdvancedSearch->ToJSON(), ","); // Field Show_Terms_And_Conditions_On_Footer
		$sFilterList = ew_Concat($sFilterList, $this->Show_About_Us_On_Footer->AdvancedSearch->ToJSON(), ","); // Field Show_About_Us_On_Footer
		$sFilterList = ew_Concat($sFilterList, $this->Pagination_Position->AdvancedSearch->ToJSON(), ","); // Field Pagination_Position
		$sFilterList = ew_Concat($sFilterList, $this->Pagination_Style->AdvancedSearch->ToJSON(), ","); // Field Pagination_Style
		$sFilterList = ew_Concat($sFilterList, $this->Selectable_Records_Per_Page->AdvancedSearch->ToJSON(), ","); // Field Selectable_Records_Per_Page
		$sFilterList = ew_Concat($sFilterList, $this->Selectable_Groups_Per_Page->AdvancedSearch->ToJSON(), ","); // Field Selectable_Groups_Per_Page
		$sFilterList = ew_Concat($sFilterList, $this->Default_Record_Per_Page->AdvancedSearch->ToJSON(), ","); // Field Default_Record_Per_Page
		$sFilterList = ew_Concat($sFilterList, $this->Default_Group_Per_Page->AdvancedSearch->ToJSON(), ","); // Field Default_Group_Per_Page
		$sFilterList = ew_Concat($sFilterList, $this->Maximum_Selected_Records->AdvancedSearch->ToJSON(), ","); // Field Maximum_Selected_Records
		$sFilterList = ew_Concat($sFilterList, $this->Maximum_Selected_Groups->AdvancedSearch->ToJSON(), ","); // Field Maximum_Selected_Groups
		$sFilterList = ew_Concat($sFilterList, $this->Show_PageNum_If_Record_Not_Over_Pagesize->AdvancedSearch->ToJSON(), ","); // Field Show_PageNum_If_Record_Not_Over_Pagesize
		$sFilterList = ew_Concat($sFilterList, $this->Table_Width_Style->AdvancedSearch->ToJSON(), ","); // Field Table_Width_Style
		$sFilterList = ew_Concat($sFilterList, $this->Scroll_Table_Width->AdvancedSearch->ToJSON(), ","); // Field Scroll_Table_Width
		$sFilterList = ew_Concat($sFilterList, $this->Scroll_Table_Height->AdvancedSearch->ToJSON(), ","); // Field Scroll_Table_Height
		$sFilterList = ew_Concat($sFilterList, $this->Search_Panel_Collapsed->AdvancedSearch->ToJSON(), ","); // Field Search_Panel_Collapsed
		$sFilterList = ew_Concat($sFilterList, $this->Filter_Panel_Collapsed->AdvancedSearch->ToJSON(), ","); // Field Filter_Panel_Collapsed
		$sFilterList = ew_Concat($sFilterList, $this->Show_Record_Number_On_List_Page->AdvancedSearch->ToJSON(), ","); // Field Show_Record_Number_On_List_Page
		$sFilterList = ew_Concat($sFilterList, $this->Show_Empty_Table_On_List_Page->AdvancedSearch->ToJSON(), ","); // Field Show_Empty_Table_On_List_Page
		$sFilterList = ew_Concat($sFilterList, $this->Rows_Vertical_Align_Top->AdvancedSearch->ToJSON(), ","); // Field Rows_Vertical_Align_Top
		$sFilterList = ew_Concat($sFilterList, $this->Action_Button_Alignment->AdvancedSearch->ToJSON(), ","); // Field Action_Button_Alignment
		$sFilterList = ew_Concat($sFilterList, $this->Show_Add_Success_Message->AdvancedSearch->ToJSON(), ","); // Field Show_Add_Success_Message
		$sFilterList = ew_Concat($sFilterList, $this->Show_Edit_Success_Message->AdvancedSearch->ToJSON(), ","); // Field Show_Edit_Success_Message
		$sFilterList = ew_Concat($sFilterList, $this->jQuery_Auto_Hide_Success_Message->AdvancedSearch->ToJSON(), ","); // Field jQuery_Auto_Hide_Success_Message
		$sFilterList = ew_Concat($sFilterList, $this->Use_Javascript_Message->AdvancedSearch->ToJSON(), ","); // Field Use_Javascript_Message
		$sFilterList = ew_Concat($sFilterList, $this->Login_Window_Type->AdvancedSearch->ToJSON(), ","); // Field Login_Window_Type
		$sFilterList = ew_Concat($sFilterList, $this->Forgot_Password_Window_Type->AdvancedSearch->ToJSON(), ","); // Field Forgot_Password_Window_Type
		$sFilterList = ew_Concat($sFilterList, $this->Change_Password_Window_Type->AdvancedSearch->ToJSON(), ","); // Field Change_Password_Window_Type
		$sFilterList = ew_Concat($sFilterList, $this->Registration_Window_Type->AdvancedSearch->ToJSON(), ","); // Field Registration_Window_Type
		$sFilterList = ew_Concat($sFilterList, $this->Show_Record_Number_On_Detail_Preview->AdvancedSearch->ToJSON(), ","); // Field Show_Record_Number_On_Detail_Preview
		$sFilterList = ew_Concat($sFilterList, $this->Show_Empty_Table_In_Detail_Preview->AdvancedSearch->ToJSON(), ","); // Field Show_Empty_Table_In_Detail_Preview
		$sFilterList = ew_Concat($sFilterList, $this->Detail_Preview_Table_Width->AdvancedSearch->ToJSON(), ","); // Field Detail_Preview_Table_Width
		$sFilterList = ew_Concat($sFilterList, $this->Password_Minimum_Length->AdvancedSearch->ToJSON(), ","); // Field Password_Minimum_Length
		$sFilterList = ew_Concat($sFilterList, $this->Password_Maximum_Length->AdvancedSearch->ToJSON(), ","); // Field Password_Maximum_Length
		$sFilterList = ew_Concat($sFilterList, $this->Password_Must_Contain_At_Least_One_Lower_Case->AdvancedSearch->ToJSON(), ","); // Field Password_Must_Contain_At_Least_One_Lower_Case
		$sFilterList = ew_Concat($sFilterList, $this->Password_Must_Comply_With_Minumum_Length->AdvancedSearch->ToJSON(), ","); // Field Password_Must_Comply_With_Minumum_Length
		$sFilterList = ew_Concat($sFilterList, $this->Password_Must_Comply_With_Maximum_Length->AdvancedSearch->ToJSON(), ","); // Field Password_Must_Comply_With_Maximum_Length
		$sFilterList = ew_Concat($sFilterList, $this->Password_Must_Contain_At_Least_One_Upper_Case->AdvancedSearch->ToJSON(), ","); // Field Password_Must_Contain_At_Least_One_Upper_Case
		$sFilterList = ew_Concat($sFilterList, $this->Password_Must_Contain_At_Least_One_Numeric->AdvancedSearch->ToJSON(), ","); // Field Password_Must_Contain_At_Least_One_Numeric
		$sFilterList = ew_Concat($sFilterList, $this->Password_Must_Contain_At_Least_One_Symbol->AdvancedSearch->ToJSON(), ","); // Field Password_Must_Contain_At_Least_One_Symbol
		$sFilterList = ew_Concat($sFilterList, $this->Password_Must_Be_Difference_Between_Old_And_New->AdvancedSearch->ToJSON(), ","); // Field Password_Must_Be_Difference_Between_Old_And_New
		$sFilterList = ew_Concat($sFilterList, $this->Reset_Password_Field_Options->AdvancedSearch->ToJSON(), ","); // Field Reset_Password_Field_Options
		$sFilterList = ew_Concat($sFilterList, $this->Export_Record_Options->AdvancedSearch->ToJSON(), ","); // Field Export_Record_Options
		$sFilterList = ew_Concat($sFilterList, $this->Show_Record_Number_On_Exported_List_Page->AdvancedSearch->ToJSON(), ","); // Field Show_Record_Number_On_Exported_List_Page
		$sFilterList = ew_Concat($sFilterList, $this->Use_Table_Setting_For_Export_Field_Caption->AdvancedSearch->ToJSON(), ","); // Field Use_Table_Setting_For_Export_Field_Caption
		$sFilterList = ew_Concat($sFilterList, $this->Use_Table_Setting_For_Export_Original_Value->AdvancedSearch->ToJSON(), ","); // Field Use_Table_Setting_For_Export_Original_Value
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

		// Field Option_ID
		$this->Option_ID->AdvancedSearch->SearchValue = @$filter["x_Option_ID"];
		$this->Option_ID->AdvancedSearch->SearchOperator = @$filter["z_Option_ID"];
		$this->Option_ID->AdvancedSearch->SearchCondition = @$filter["v_Option_ID"];
		$this->Option_ID->AdvancedSearch->SearchValue2 = @$filter["y_Option_ID"];
		$this->Option_ID->AdvancedSearch->SearchOperator2 = @$filter["w_Option_ID"];
		$this->Option_ID->AdvancedSearch->Save();

		// Field Option_Default
		$this->Option_Default->AdvancedSearch->SearchValue = @$filter["x_Option_Default"];
		$this->Option_Default->AdvancedSearch->SearchOperator = @$filter["z_Option_Default"];
		$this->Option_Default->AdvancedSearch->SearchCondition = @$filter["v_Option_Default"];
		$this->Option_Default->AdvancedSearch->SearchValue2 = @$filter["y_Option_Default"];
		$this->Option_Default->AdvancedSearch->SearchOperator2 = @$filter["w_Option_Default"];
		$this->Option_Default->AdvancedSearch->Save();

		// Field Default_Theme
		$this->Default_Theme->AdvancedSearch->SearchValue = @$filter["x_Default_Theme"];
		$this->Default_Theme->AdvancedSearch->SearchOperator = @$filter["z_Default_Theme"];
		$this->Default_Theme->AdvancedSearch->SearchCondition = @$filter["v_Default_Theme"];
		$this->Default_Theme->AdvancedSearch->SearchValue2 = @$filter["y_Default_Theme"];
		$this->Default_Theme->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Theme"];
		$this->Default_Theme->AdvancedSearch->Save();

		// Field Font_Name
		$this->Font_Name->AdvancedSearch->SearchValue = @$filter["x_Font_Name"];
		$this->Font_Name->AdvancedSearch->SearchOperator = @$filter["z_Font_Name"];
		$this->Font_Name->AdvancedSearch->SearchCondition = @$filter["v_Font_Name"];
		$this->Font_Name->AdvancedSearch->SearchValue2 = @$filter["y_Font_Name"];
		$this->Font_Name->AdvancedSearch->SearchOperator2 = @$filter["w_Font_Name"];
		$this->Font_Name->AdvancedSearch->Save();

		// Field Font_Size
		$this->Font_Size->AdvancedSearch->SearchValue = @$filter["x_Font_Size"];
		$this->Font_Size->AdvancedSearch->SearchOperator = @$filter["z_Font_Size"];
		$this->Font_Size->AdvancedSearch->SearchCondition = @$filter["v_Font_Size"];
		$this->Font_Size->AdvancedSearch->SearchValue2 = @$filter["y_Font_Size"];
		$this->Font_Size->AdvancedSearch->SearchOperator2 = @$filter["w_Font_Size"];
		$this->Font_Size->AdvancedSearch->Save();

		// Field Show_Border_Layout
		$this->Show_Border_Layout->AdvancedSearch->SearchValue = @$filter["x_Show_Border_Layout"];
		$this->Show_Border_Layout->AdvancedSearch->SearchOperator = @$filter["z_Show_Border_Layout"];
		$this->Show_Border_Layout->AdvancedSearch->SearchCondition = @$filter["v_Show_Border_Layout"];
		$this->Show_Border_Layout->AdvancedSearch->SearchValue2 = @$filter["y_Show_Border_Layout"];
		$this->Show_Border_Layout->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Border_Layout"];
		$this->Show_Border_Layout->AdvancedSearch->Save();

		// Field Show_Shadow_Layout
		$this->Show_Shadow_Layout->AdvancedSearch->SearchValue = @$filter["x_Show_Shadow_Layout"];
		$this->Show_Shadow_Layout->AdvancedSearch->SearchOperator = @$filter["z_Show_Shadow_Layout"];
		$this->Show_Shadow_Layout->AdvancedSearch->SearchCondition = @$filter["v_Show_Shadow_Layout"];
		$this->Show_Shadow_Layout->AdvancedSearch->SearchValue2 = @$filter["y_Show_Shadow_Layout"];
		$this->Show_Shadow_Layout->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Shadow_Layout"];
		$this->Show_Shadow_Layout->AdvancedSearch->Save();

		// Field Menu_Horizontal
		$this->Menu_Horizontal->AdvancedSearch->SearchValue = @$filter["x_Menu_Horizontal"];
		$this->Menu_Horizontal->AdvancedSearch->SearchOperator = @$filter["z_Menu_Horizontal"];
		$this->Menu_Horizontal->AdvancedSearch->SearchCondition = @$filter["v_Menu_Horizontal"];
		$this->Menu_Horizontal->AdvancedSearch->SearchValue2 = @$filter["y_Menu_Horizontal"];
		$this->Menu_Horizontal->AdvancedSearch->SearchOperator2 = @$filter["w_Menu_Horizontal"];
		$this->Menu_Horizontal->AdvancedSearch->Save();

		// Field Vertical_Menu_Width
		$this->Vertical_Menu_Width->AdvancedSearch->SearchValue = @$filter["x_Vertical_Menu_Width"];
		$this->Vertical_Menu_Width->AdvancedSearch->SearchOperator = @$filter["z_Vertical_Menu_Width"];
		$this->Vertical_Menu_Width->AdvancedSearch->SearchCondition = @$filter["v_Vertical_Menu_Width"];
		$this->Vertical_Menu_Width->AdvancedSearch->SearchValue2 = @$filter["y_Vertical_Menu_Width"];
		$this->Vertical_Menu_Width->AdvancedSearch->SearchOperator2 = @$filter["w_Vertical_Menu_Width"];
		$this->Vertical_Menu_Width->AdvancedSearch->Save();

		// Field Show_Announcement
		$this->Show_Announcement->AdvancedSearch->SearchValue = @$filter["x_Show_Announcement"];
		$this->Show_Announcement->AdvancedSearch->SearchOperator = @$filter["z_Show_Announcement"];
		$this->Show_Announcement->AdvancedSearch->SearchCondition = @$filter["v_Show_Announcement"];
		$this->Show_Announcement->AdvancedSearch->SearchValue2 = @$filter["y_Show_Announcement"];
		$this->Show_Announcement->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Announcement"];
		$this->Show_Announcement->AdvancedSearch->Save();

		// Field Demo_Mode
		$this->Demo_Mode->AdvancedSearch->SearchValue = @$filter["x_Demo_Mode"];
		$this->Demo_Mode->AdvancedSearch->SearchOperator = @$filter["z_Demo_Mode"];
		$this->Demo_Mode->AdvancedSearch->SearchCondition = @$filter["v_Demo_Mode"];
		$this->Demo_Mode->AdvancedSearch->SearchValue2 = @$filter["y_Demo_Mode"];
		$this->Demo_Mode->AdvancedSearch->SearchOperator2 = @$filter["w_Demo_Mode"];
		$this->Demo_Mode->AdvancedSearch->Save();

		// Field Show_Page_Processing_Time
		$this->Show_Page_Processing_Time->AdvancedSearch->SearchValue = @$filter["x_Show_Page_Processing_Time"];
		$this->Show_Page_Processing_Time->AdvancedSearch->SearchOperator = @$filter["z_Show_Page_Processing_Time"];
		$this->Show_Page_Processing_Time->AdvancedSearch->SearchCondition = @$filter["v_Show_Page_Processing_Time"];
		$this->Show_Page_Processing_Time->AdvancedSearch->SearchValue2 = @$filter["y_Show_Page_Processing_Time"];
		$this->Show_Page_Processing_Time->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Page_Processing_Time"];
		$this->Show_Page_Processing_Time->AdvancedSearch->Save();

		// Field Allow_User_Preferences
		$this->Allow_User_Preferences->AdvancedSearch->SearchValue = @$filter["x_Allow_User_Preferences"];
		$this->Allow_User_Preferences->AdvancedSearch->SearchOperator = @$filter["z_Allow_User_Preferences"];
		$this->Allow_User_Preferences->AdvancedSearch->SearchCondition = @$filter["v_Allow_User_Preferences"];
		$this->Allow_User_Preferences->AdvancedSearch->SearchValue2 = @$filter["y_Allow_User_Preferences"];
		$this->Allow_User_Preferences->AdvancedSearch->SearchOperator2 = @$filter["w_Allow_User_Preferences"];
		$this->Allow_User_Preferences->AdvancedSearch->Save();

		// Field SMTP_Server
		$this->SMTP_Server->AdvancedSearch->SearchValue = @$filter["x_SMTP_Server"];
		$this->SMTP_Server->AdvancedSearch->SearchOperator = @$filter["z_SMTP_Server"];
		$this->SMTP_Server->AdvancedSearch->SearchCondition = @$filter["v_SMTP_Server"];
		$this->SMTP_Server->AdvancedSearch->SearchValue2 = @$filter["y_SMTP_Server"];
		$this->SMTP_Server->AdvancedSearch->SearchOperator2 = @$filter["w_SMTP_Server"];
		$this->SMTP_Server->AdvancedSearch->Save();

		// Field SMTP_Server_Port
		$this->SMTP_Server_Port->AdvancedSearch->SearchValue = @$filter["x_SMTP_Server_Port"];
		$this->SMTP_Server_Port->AdvancedSearch->SearchOperator = @$filter["z_SMTP_Server_Port"];
		$this->SMTP_Server_Port->AdvancedSearch->SearchCondition = @$filter["v_SMTP_Server_Port"];
		$this->SMTP_Server_Port->AdvancedSearch->SearchValue2 = @$filter["y_SMTP_Server_Port"];
		$this->SMTP_Server_Port->AdvancedSearch->SearchOperator2 = @$filter["w_SMTP_Server_Port"];
		$this->SMTP_Server_Port->AdvancedSearch->Save();

		// Field SMTP_Server_Username
		$this->SMTP_Server_Username->AdvancedSearch->SearchValue = @$filter["x_SMTP_Server_Username"];
		$this->SMTP_Server_Username->AdvancedSearch->SearchOperator = @$filter["z_SMTP_Server_Username"];
		$this->SMTP_Server_Username->AdvancedSearch->SearchCondition = @$filter["v_SMTP_Server_Username"];
		$this->SMTP_Server_Username->AdvancedSearch->SearchValue2 = @$filter["y_SMTP_Server_Username"];
		$this->SMTP_Server_Username->AdvancedSearch->SearchOperator2 = @$filter["w_SMTP_Server_Username"];
		$this->SMTP_Server_Username->AdvancedSearch->Save();

		// Field SMTP_Server_Password
		$this->SMTP_Server_Password->AdvancedSearch->SearchValue = @$filter["x_SMTP_Server_Password"];
		$this->SMTP_Server_Password->AdvancedSearch->SearchOperator = @$filter["z_SMTP_Server_Password"];
		$this->SMTP_Server_Password->AdvancedSearch->SearchCondition = @$filter["v_SMTP_Server_Password"];
		$this->SMTP_Server_Password->AdvancedSearch->SearchValue2 = @$filter["y_SMTP_Server_Password"];
		$this->SMTP_Server_Password->AdvancedSearch->SearchOperator2 = @$filter["w_SMTP_Server_Password"];
		$this->SMTP_Server_Password->AdvancedSearch->Save();

		// Field Sender_Email
		$this->Sender_Email->AdvancedSearch->SearchValue = @$filter["x_Sender_Email"];
		$this->Sender_Email->AdvancedSearch->SearchOperator = @$filter["z_Sender_Email"];
		$this->Sender_Email->AdvancedSearch->SearchCondition = @$filter["v_Sender_Email"];
		$this->Sender_Email->AdvancedSearch->SearchValue2 = @$filter["y_Sender_Email"];
		$this->Sender_Email->AdvancedSearch->SearchOperator2 = @$filter["w_Sender_Email"];
		$this->Sender_Email->AdvancedSearch->Save();

		// Field Recipient_Email
		$this->Recipient_Email->AdvancedSearch->SearchValue = @$filter["x_Recipient_Email"];
		$this->Recipient_Email->AdvancedSearch->SearchOperator = @$filter["z_Recipient_Email"];
		$this->Recipient_Email->AdvancedSearch->SearchCondition = @$filter["v_Recipient_Email"];
		$this->Recipient_Email->AdvancedSearch->SearchValue2 = @$filter["y_Recipient_Email"];
		$this->Recipient_Email->AdvancedSearch->SearchOperator2 = @$filter["w_Recipient_Email"];
		$this->Recipient_Email->AdvancedSearch->Save();

		// Field Use_Default_Locale
		$this->Use_Default_Locale->AdvancedSearch->SearchValue = @$filter["x_Use_Default_Locale"];
		$this->Use_Default_Locale->AdvancedSearch->SearchOperator = @$filter["z_Use_Default_Locale"];
		$this->Use_Default_Locale->AdvancedSearch->SearchCondition = @$filter["v_Use_Default_Locale"];
		$this->Use_Default_Locale->AdvancedSearch->SearchValue2 = @$filter["y_Use_Default_Locale"];
		$this->Use_Default_Locale->AdvancedSearch->SearchOperator2 = @$filter["w_Use_Default_Locale"];
		$this->Use_Default_Locale->AdvancedSearch->Save();

		// Field Default_Language
		$this->Default_Language->AdvancedSearch->SearchValue = @$filter["x_Default_Language"];
		$this->Default_Language->AdvancedSearch->SearchOperator = @$filter["z_Default_Language"];
		$this->Default_Language->AdvancedSearch->SearchCondition = @$filter["v_Default_Language"];
		$this->Default_Language->AdvancedSearch->SearchValue2 = @$filter["y_Default_Language"];
		$this->Default_Language->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Language"];
		$this->Default_Language->AdvancedSearch->Save();

		// Field Default_Timezone
		$this->Default_Timezone->AdvancedSearch->SearchValue = @$filter["x_Default_Timezone"];
		$this->Default_Timezone->AdvancedSearch->SearchOperator = @$filter["z_Default_Timezone"];
		$this->Default_Timezone->AdvancedSearch->SearchCondition = @$filter["v_Default_Timezone"];
		$this->Default_Timezone->AdvancedSearch->SearchValue2 = @$filter["y_Default_Timezone"];
		$this->Default_Timezone->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Timezone"];
		$this->Default_Timezone->AdvancedSearch->Save();

		// Field Default_Thousands_Separator
		$this->Default_Thousands_Separator->AdvancedSearch->SearchValue = @$filter["x_Default_Thousands_Separator"];
		$this->Default_Thousands_Separator->AdvancedSearch->SearchOperator = @$filter["z_Default_Thousands_Separator"];
		$this->Default_Thousands_Separator->AdvancedSearch->SearchCondition = @$filter["v_Default_Thousands_Separator"];
		$this->Default_Thousands_Separator->AdvancedSearch->SearchValue2 = @$filter["y_Default_Thousands_Separator"];
		$this->Default_Thousands_Separator->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Thousands_Separator"];
		$this->Default_Thousands_Separator->AdvancedSearch->Save();

		// Field Default_Decimal_Point
		$this->Default_Decimal_Point->AdvancedSearch->SearchValue = @$filter["x_Default_Decimal_Point"];
		$this->Default_Decimal_Point->AdvancedSearch->SearchOperator = @$filter["z_Default_Decimal_Point"];
		$this->Default_Decimal_Point->AdvancedSearch->SearchCondition = @$filter["v_Default_Decimal_Point"];
		$this->Default_Decimal_Point->AdvancedSearch->SearchValue2 = @$filter["y_Default_Decimal_Point"];
		$this->Default_Decimal_Point->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Decimal_Point"];
		$this->Default_Decimal_Point->AdvancedSearch->Save();

		// Field Default_Currency_Symbol
		$this->Default_Currency_Symbol->AdvancedSearch->SearchValue = @$filter["x_Default_Currency_Symbol"];
		$this->Default_Currency_Symbol->AdvancedSearch->SearchOperator = @$filter["z_Default_Currency_Symbol"];
		$this->Default_Currency_Symbol->AdvancedSearch->SearchCondition = @$filter["v_Default_Currency_Symbol"];
		$this->Default_Currency_Symbol->AdvancedSearch->SearchValue2 = @$filter["y_Default_Currency_Symbol"];
		$this->Default_Currency_Symbol->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Currency_Symbol"];
		$this->Default_Currency_Symbol->AdvancedSearch->Save();

		// Field Default_Money_Thousands_Separator
		$this->Default_Money_Thousands_Separator->AdvancedSearch->SearchValue = @$filter["x_Default_Money_Thousands_Separator"];
		$this->Default_Money_Thousands_Separator->AdvancedSearch->SearchOperator = @$filter["z_Default_Money_Thousands_Separator"];
		$this->Default_Money_Thousands_Separator->AdvancedSearch->SearchCondition = @$filter["v_Default_Money_Thousands_Separator"];
		$this->Default_Money_Thousands_Separator->AdvancedSearch->SearchValue2 = @$filter["y_Default_Money_Thousands_Separator"];
		$this->Default_Money_Thousands_Separator->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Money_Thousands_Separator"];
		$this->Default_Money_Thousands_Separator->AdvancedSearch->Save();

		// Field Default_Money_Decimal_Point
		$this->Default_Money_Decimal_Point->AdvancedSearch->SearchValue = @$filter["x_Default_Money_Decimal_Point"];
		$this->Default_Money_Decimal_Point->AdvancedSearch->SearchOperator = @$filter["z_Default_Money_Decimal_Point"];
		$this->Default_Money_Decimal_Point->AdvancedSearch->SearchCondition = @$filter["v_Default_Money_Decimal_Point"];
		$this->Default_Money_Decimal_Point->AdvancedSearch->SearchValue2 = @$filter["y_Default_Money_Decimal_Point"];
		$this->Default_Money_Decimal_Point->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Money_Decimal_Point"];
		$this->Default_Money_Decimal_Point->AdvancedSearch->Save();

		// Field Maintenance_Mode
		$this->Maintenance_Mode->AdvancedSearch->SearchValue = @$filter["x_Maintenance_Mode"];
		$this->Maintenance_Mode->AdvancedSearch->SearchOperator = @$filter["z_Maintenance_Mode"];
		$this->Maintenance_Mode->AdvancedSearch->SearchCondition = @$filter["v_Maintenance_Mode"];
		$this->Maintenance_Mode->AdvancedSearch->SearchValue2 = @$filter["y_Maintenance_Mode"];
		$this->Maintenance_Mode->AdvancedSearch->SearchOperator2 = @$filter["w_Maintenance_Mode"];
		$this->Maintenance_Mode->AdvancedSearch->Save();

		// Field Maintenance_Finish_DateTime
		$this->Maintenance_Finish_DateTime->AdvancedSearch->SearchValue = @$filter["x_Maintenance_Finish_DateTime"];
		$this->Maintenance_Finish_DateTime->AdvancedSearch->SearchOperator = @$filter["z_Maintenance_Finish_DateTime"];
		$this->Maintenance_Finish_DateTime->AdvancedSearch->SearchCondition = @$filter["v_Maintenance_Finish_DateTime"];
		$this->Maintenance_Finish_DateTime->AdvancedSearch->SearchValue2 = @$filter["y_Maintenance_Finish_DateTime"];
		$this->Maintenance_Finish_DateTime->AdvancedSearch->SearchOperator2 = @$filter["w_Maintenance_Finish_DateTime"];
		$this->Maintenance_Finish_DateTime->AdvancedSearch->Save();

		// Field Auto_Normal_After_Maintenance
		$this->Auto_Normal_After_Maintenance->AdvancedSearch->SearchValue = @$filter["x_Auto_Normal_After_Maintenance"];
		$this->Auto_Normal_After_Maintenance->AdvancedSearch->SearchOperator = @$filter["z_Auto_Normal_After_Maintenance"];
		$this->Auto_Normal_After_Maintenance->AdvancedSearch->SearchCondition = @$filter["v_Auto_Normal_After_Maintenance"];
		$this->Auto_Normal_After_Maintenance->AdvancedSearch->SearchValue2 = @$filter["y_Auto_Normal_After_Maintenance"];
		$this->Auto_Normal_After_Maintenance->AdvancedSearch->SearchOperator2 = @$filter["w_Auto_Normal_After_Maintenance"];
		$this->Auto_Normal_After_Maintenance->AdvancedSearch->Save();

		// Field Allow_User_To_Register
		$this->Allow_User_To_Register->AdvancedSearch->SearchValue = @$filter["x_Allow_User_To_Register"];
		$this->Allow_User_To_Register->AdvancedSearch->SearchOperator = @$filter["z_Allow_User_To_Register"];
		$this->Allow_User_To_Register->AdvancedSearch->SearchCondition = @$filter["v_Allow_User_To_Register"];
		$this->Allow_User_To_Register->AdvancedSearch->SearchValue2 = @$filter["y_Allow_User_To_Register"];
		$this->Allow_User_To_Register->AdvancedSearch->SearchOperator2 = @$filter["w_Allow_User_To_Register"];
		$this->Allow_User_To_Register->AdvancedSearch->Save();

		// Field Suspend_New_User_Account
		$this->Suspend_New_User_Account->AdvancedSearch->SearchValue = @$filter["x_Suspend_New_User_Account"];
		$this->Suspend_New_User_Account->AdvancedSearch->SearchOperator = @$filter["z_Suspend_New_User_Account"];
		$this->Suspend_New_User_Account->AdvancedSearch->SearchCondition = @$filter["v_Suspend_New_User_Account"];
		$this->Suspend_New_User_Account->AdvancedSearch->SearchValue2 = @$filter["y_Suspend_New_User_Account"];
		$this->Suspend_New_User_Account->AdvancedSearch->SearchOperator2 = @$filter["w_Suspend_New_User_Account"];
		$this->Suspend_New_User_Account->AdvancedSearch->Save();

		// Field User_Need_Activation_After_Registered
		$this->User_Need_Activation_After_Registered->AdvancedSearch->SearchValue = @$filter["x_User_Need_Activation_After_Registered"];
		$this->User_Need_Activation_After_Registered->AdvancedSearch->SearchOperator = @$filter["z_User_Need_Activation_After_Registered"];
		$this->User_Need_Activation_After_Registered->AdvancedSearch->SearchCondition = @$filter["v_User_Need_Activation_After_Registered"];
		$this->User_Need_Activation_After_Registered->AdvancedSearch->SearchValue2 = @$filter["y_User_Need_Activation_After_Registered"];
		$this->User_Need_Activation_After_Registered->AdvancedSearch->SearchOperator2 = @$filter["w_User_Need_Activation_After_Registered"];
		$this->User_Need_Activation_After_Registered->AdvancedSearch->Save();

		// Field Show_Captcha_On_Registration_Page
		$this->Show_Captcha_On_Registration_Page->AdvancedSearch->SearchValue = @$filter["x_Show_Captcha_On_Registration_Page"];
		$this->Show_Captcha_On_Registration_Page->AdvancedSearch->SearchOperator = @$filter["z_Show_Captcha_On_Registration_Page"];
		$this->Show_Captcha_On_Registration_Page->AdvancedSearch->SearchCondition = @$filter["v_Show_Captcha_On_Registration_Page"];
		$this->Show_Captcha_On_Registration_Page->AdvancedSearch->SearchValue2 = @$filter["y_Show_Captcha_On_Registration_Page"];
		$this->Show_Captcha_On_Registration_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Captcha_On_Registration_Page"];
		$this->Show_Captcha_On_Registration_Page->AdvancedSearch->Save();

		// Field Show_Terms_And_Conditions_On_Registration_Page
		$this->Show_Terms_And_Conditions_On_Registration_Page->AdvancedSearch->SearchValue = @$filter["x_Show_Terms_And_Conditions_On_Registration_Page"];
		$this->Show_Terms_And_Conditions_On_Registration_Page->AdvancedSearch->SearchOperator = @$filter["z_Show_Terms_And_Conditions_On_Registration_Page"];
		$this->Show_Terms_And_Conditions_On_Registration_Page->AdvancedSearch->SearchCondition = @$filter["v_Show_Terms_And_Conditions_On_Registration_Page"];
		$this->Show_Terms_And_Conditions_On_Registration_Page->AdvancedSearch->SearchValue2 = @$filter["y_Show_Terms_And_Conditions_On_Registration_Page"];
		$this->Show_Terms_And_Conditions_On_Registration_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Terms_And_Conditions_On_Registration_Page"];
		$this->Show_Terms_And_Conditions_On_Registration_Page->AdvancedSearch->Save();

		// Field User_Auto_Login_After_Activation_Or_Registration
		$this->User_Auto_Login_After_Activation_Or_Registration->AdvancedSearch->SearchValue = @$filter["x_User_Auto_Login_After_Activation_Or_Registration"];
		$this->User_Auto_Login_After_Activation_Or_Registration->AdvancedSearch->SearchOperator = @$filter["z_User_Auto_Login_After_Activation_Or_Registration"];
		$this->User_Auto_Login_After_Activation_Or_Registration->AdvancedSearch->SearchCondition = @$filter["v_User_Auto_Login_After_Activation_Or_Registration"];
		$this->User_Auto_Login_After_Activation_Or_Registration->AdvancedSearch->SearchValue2 = @$filter["y_User_Auto_Login_After_Activation_Or_Registration"];
		$this->User_Auto_Login_After_Activation_Or_Registration->AdvancedSearch->SearchOperator2 = @$filter["w_User_Auto_Login_After_Activation_Or_Registration"];
		$this->User_Auto_Login_After_Activation_Or_Registration->AdvancedSearch->Save();

		// Field Show_Captcha_On_Login_Page
		$this->Show_Captcha_On_Login_Page->AdvancedSearch->SearchValue = @$filter["x_Show_Captcha_On_Login_Page"];
		$this->Show_Captcha_On_Login_Page->AdvancedSearch->SearchOperator = @$filter["z_Show_Captcha_On_Login_Page"];
		$this->Show_Captcha_On_Login_Page->AdvancedSearch->SearchCondition = @$filter["v_Show_Captcha_On_Login_Page"];
		$this->Show_Captcha_On_Login_Page->AdvancedSearch->SearchValue2 = @$filter["y_Show_Captcha_On_Login_Page"];
		$this->Show_Captcha_On_Login_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Captcha_On_Login_Page"];
		$this->Show_Captcha_On_Login_Page->AdvancedSearch->Save();

		// Field Show_Captcha_On_Forgot_Password_Page
		$this->Show_Captcha_On_Forgot_Password_Page->AdvancedSearch->SearchValue = @$filter["x_Show_Captcha_On_Forgot_Password_Page"];
		$this->Show_Captcha_On_Forgot_Password_Page->AdvancedSearch->SearchOperator = @$filter["z_Show_Captcha_On_Forgot_Password_Page"];
		$this->Show_Captcha_On_Forgot_Password_Page->AdvancedSearch->SearchCondition = @$filter["v_Show_Captcha_On_Forgot_Password_Page"];
		$this->Show_Captcha_On_Forgot_Password_Page->AdvancedSearch->SearchValue2 = @$filter["y_Show_Captcha_On_Forgot_Password_Page"];
		$this->Show_Captcha_On_Forgot_Password_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Captcha_On_Forgot_Password_Page"];
		$this->Show_Captcha_On_Forgot_Password_Page->AdvancedSearch->Save();

		// Field Show_Captcha_On_Change_Password_Page
		$this->Show_Captcha_On_Change_Password_Page->AdvancedSearch->SearchValue = @$filter["x_Show_Captcha_On_Change_Password_Page"];
		$this->Show_Captcha_On_Change_Password_Page->AdvancedSearch->SearchOperator = @$filter["z_Show_Captcha_On_Change_Password_Page"];
		$this->Show_Captcha_On_Change_Password_Page->AdvancedSearch->SearchCondition = @$filter["v_Show_Captcha_On_Change_Password_Page"];
		$this->Show_Captcha_On_Change_Password_Page->AdvancedSearch->SearchValue2 = @$filter["y_Show_Captcha_On_Change_Password_Page"];
		$this->Show_Captcha_On_Change_Password_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Captcha_On_Change_Password_Page"];
		$this->Show_Captcha_On_Change_Password_Page->AdvancedSearch->Save();

		// Field User_Auto_Logout_After_Idle_In_Minutes
		$this->User_Auto_Logout_After_Idle_In_Minutes->AdvancedSearch->SearchValue = @$filter["x_User_Auto_Logout_After_Idle_In_Minutes"];
		$this->User_Auto_Logout_After_Idle_In_Minutes->AdvancedSearch->SearchOperator = @$filter["z_User_Auto_Logout_After_Idle_In_Minutes"];
		$this->User_Auto_Logout_After_Idle_In_Minutes->AdvancedSearch->SearchCondition = @$filter["v_User_Auto_Logout_After_Idle_In_Minutes"];
		$this->User_Auto_Logout_After_Idle_In_Minutes->AdvancedSearch->SearchValue2 = @$filter["y_User_Auto_Logout_After_Idle_In_Minutes"];
		$this->User_Auto_Logout_After_Idle_In_Minutes->AdvancedSearch->SearchOperator2 = @$filter["w_User_Auto_Logout_After_Idle_In_Minutes"];
		$this->User_Auto_Logout_After_Idle_In_Minutes->AdvancedSearch->Save();

		// Field User_Login_Maximum_Retry
		$this->User_Login_Maximum_Retry->AdvancedSearch->SearchValue = @$filter["x_User_Login_Maximum_Retry"];
		$this->User_Login_Maximum_Retry->AdvancedSearch->SearchOperator = @$filter["z_User_Login_Maximum_Retry"];
		$this->User_Login_Maximum_Retry->AdvancedSearch->SearchCondition = @$filter["v_User_Login_Maximum_Retry"];
		$this->User_Login_Maximum_Retry->AdvancedSearch->SearchValue2 = @$filter["y_User_Login_Maximum_Retry"];
		$this->User_Login_Maximum_Retry->AdvancedSearch->SearchOperator2 = @$filter["w_User_Login_Maximum_Retry"];
		$this->User_Login_Maximum_Retry->AdvancedSearch->Save();

		// Field User_Login_Retry_Lockout
		$this->User_Login_Retry_Lockout->AdvancedSearch->SearchValue = @$filter["x_User_Login_Retry_Lockout"];
		$this->User_Login_Retry_Lockout->AdvancedSearch->SearchOperator = @$filter["z_User_Login_Retry_Lockout"];
		$this->User_Login_Retry_Lockout->AdvancedSearch->SearchCondition = @$filter["v_User_Login_Retry_Lockout"];
		$this->User_Login_Retry_Lockout->AdvancedSearch->SearchValue2 = @$filter["y_User_Login_Retry_Lockout"];
		$this->User_Login_Retry_Lockout->AdvancedSearch->SearchOperator2 = @$filter["w_User_Login_Retry_Lockout"];
		$this->User_Login_Retry_Lockout->AdvancedSearch->Save();

		// Field Redirect_To_Last_Visited_Page_After_Login
		$this->Redirect_To_Last_Visited_Page_After_Login->AdvancedSearch->SearchValue = @$filter["x_Redirect_To_Last_Visited_Page_After_Login"];
		$this->Redirect_To_Last_Visited_Page_After_Login->AdvancedSearch->SearchOperator = @$filter["z_Redirect_To_Last_Visited_Page_After_Login"];
		$this->Redirect_To_Last_Visited_Page_After_Login->AdvancedSearch->SearchCondition = @$filter["v_Redirect_To_Last_Visited_Page_After_Login"];
		$this->Redirect_To_Last_Visited_Page_After_Login->AdvancedSearch->SearchValue2 = @$filter["y_Redirect_To_Last_Visited_Page_After_Login"];
		$this->Redirect_To_Last_Visited_Page_After_Login->AdvancedSearch->SearchOperator2 = @$filter["w_Redirect_To_Last_Visited_Page_After_Login"];
		$this->Redirect_To_Last_Visited_Page_After_Login->AdvancedSearch->Save();

		// Field Enable_Password_Expiry
		$this->Enable_Password_Expiry->AdvancedSearch->SearchValue = @$filter["x_Enable_Password_Expiry"];
		$this->Enable_Password_Expiry->AdvancedSearch->SearchOperator = @$filter["z_Enable_Password_Expiry"];
		$this->Enable_Password_Expiry->AdvancedSearch->SearchCondition = @$filter["v_Enable_Password_Expiry"];
		$this->Enable_Password_Expiry->AdvancedSearch->SearchValue2 = @$filter["y_Enable_Password_Expiry"];
		$this->Enable_Password_Expiry->AdvancedSearch->SearchOperator2 = @$filter["w_Enable_Password_Expiry"];
		$this->Enable_Password_Expiry->AdvancedSearch->Save();

		// Field Password_Expiry_In_Days
		$this->Password_Expiry_In_Days->AdvancedSearch->SearchValue = @$filter["x_Password_Expiry_In_Days"];
		$this->Password_Expiry_In_Days->AdvancedSearch->SearchOperator = @$filter["z_Password_Expiry_In_Days"];
		$this->Password_Expiry_In_Days->AdvancedSearch->SearchCondition = @$filter["v_Password_Expiry_In_Days"];
		$this->Password_Expiry_In_Days->AdvancedSearch->SearchValue2 = @$filter["y_Password_Expiry_In_Days"];
		$this->Password_Expiry_In_Days->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Expiry_In_Days"];
		$this->Password_Expiry_In_Days->AdvancedSearch->Save();

		// Field Show_Entire_Header
		$this->Show_Entire_Header->AdvancedSearch->SearchValue = @$filter["x_Show_Entire_Header"];
		$this->Show_Entire_Header->AdvancedSearch->SearchOperator = @$filter["z_Show_Entire_Header"];
		$this->Show_Entire_Header->AdvancedSearch->SearchCondition = @$filter["v_Show_Entire_Header"];
		$this->Show_Entire_Header->AdvancedSearch->SearchValue2 = @$filter["y_Show_Entire_Header"];
		$this->Show_Entire_Header->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Entire_Header"];
		$this->Show_Entire_Header->AdvancedSearch->Save();

		// Field Logo_Width
		$this->Logo_Width->AdvancedSearch->SearchValue = @$filter["x_Logo_Width"];
		$this->Logo_Width->AdvancedSearch->SearchOperator = @$filter["z_Logo_Width"];
		$this->Logo_Width->AdvancedSearch->SearchCondition = @$filter["v_Logo_Width"];
		$this->Logo_Width->AdvancedSearch->SearchValue2 = @$filter["y_Logo_Width"];
		$this->Logo_Width->AdvancedSearch->SearchOperator2 = @$filter["w_Logo_Width"];
		$this->Logo_Width->AdvancedSearch->Save();

		// Field Show_Site_Title_In_Header
		$this->Show_Site_Title_In_Header->AdvancedSearch->SearchValue = @$filter["x_Show_Site_Title_In_Header"];
		$this->Show_Site_Title_In_Header->AdvancedSearch->SearchOperator = @$filter["z_Show_Site_Title_In_Header"];
		$this->Show_Site_Title_In_Header->AdvancedSearch->SearchCondition = @$filter["v_Show_Site_Title_In_Header"];
		$this->Show_Site_Title_In_Header->AdvancedSearch->SearchValue2 = @$filter["y_Show_Site_Title_In_Header"];
		$this->Show_Site_Title_In_Header->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Site_Title_In_Header"];
		$this->Show_Site_Title_In_Header->AdvancedSearch->Save();

		// Field Show_Current_User_In_Header
		$this->Show_Current_User_In_Header->AdvancedSearch->SearchValue = @$filter["x_Show_Current_User_In_Header"];
		$this->Show_Current_User_In_Header->AdvancedSearch->SearchOperator = @$filter["z_Show_Current_User_In_Header"];
		$this->Show_Current_User_In_Header->AdvancedSearch->SearchCondition = @$filter["v_Show_Current_User_In_Header"];
		$this->Show_Current_User_In_Header->AdvancedSearch->SearchValue2 = @$filter["y_Show_Current_User_In_Header"];
		$this->Show_Current_User_In_Header->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Current_User_In_Header"];
		$this->Show_Current_User_In_Header->AdvancedSearch->Save();

		// Field Text_Align_In_Header
		$this->Text_Align_In_Header->AdvancedSearch->SearchValue = @$filter["x_Text_Align_In_Header"];
		$this->Text_Align_In_Header->AdvancedSearch->SearchOperator = @$filter["z_Text_Align_In_Header"];
		$this->Text_Align_In_Header->AdvancedSearch->SearchCondition = @$filter["v_Text_Align_In_Header"];
		$this->Text_Align_In_Header->AdvancedSearch->SearchValue2 = @$filter["y_Text_Align_In_Header"];
		$this->Text_Align_In_Header->AdvancedSearch->SearchOperator2 = @$filter["w_Text_Align_In_Header"];
		$this->Text_Align_In_Header->AdvancedSearch->Save();

		// Field Site_Title_Text_Style
		$this->Site_Title_Text_Style->AdvancedSearch->SearchValue = @$filter["x_Site_Title_Text_Style"];
		$this->Site_Title_Text_Style->AdvancedSearch->SearchOperator = @$filter["z_Site_Title_Text_Style"];
		$this->Site_Title_Text_Style->AdvancedSearch->SearchCondition = @$filter["v_Site_Title_Text_Style"];
		$this->Site_Title_Text_Style->AdvancedSearch->SearchValue2 = @$filter["y_Site_Title_Text_Style"];
		$this->Site_Title_Text_Style->AdvancedSearch->SearchOperator2 = @$filter["w_Site_Title_Text_Style"];
		$this->Site_Title_Text_Style->AdvancedSearch->Save();

		// Field Language_Selector_Visibility
		$this->Language_Selector_Visibility->AdvancedSearch->SearchValue = @$filter["x_Language_Selector_Visibility"];
		$this->Language_Selector_Visibility->AdvancedSearch->SearchOperator = @$filter["z_Language_Selector_Visibility"];
		$this->Language_Selector_Visibility->AdvancedSearch->SearchCondition = @$filter["v_Language_Selector_Visibility"];
		$this->Language_Selector_Visibility->AdvancedSearch->SearchValue2 = @$filter["y_Language_Selector_Visibility"];
		$this->Language_Selector_Visibility->AdvancedSearch->SearchOperator2 = @$filter["w_Language_Selector_Visibility"];
		$this->Language_Selector_Visibility->AdvancedSearch->Save();

		// Field Language_Selector_Align
		$this->Language_Selector_Align->AdvancedSearch->SearchValue = @$filter["x_Language_Selector_Align"];
		$this->Language_Selector_Align->AdvancedSearch->SearchOperator = @$filter["z_Language_Selector_Align"];
		$this->Language_Selector_Align->AdvancedSearch->SearchCondition = @$filter["v_Language_Selector_Align"];
		$this->Language_Selector_Align->AdvancedSearch->SearchValue2 = @$filter["y_Language_Selector_Align"];
		$this->Language_Selector_Align->AdvancedSearch->SearchOperator2 = @$filter["w_Language_Selector_Align"];
		$this->Language_Selector_Align->AdvancedSearch->Save();

		// Field Show_Entire_Footer
		$this->Show_Entire_Footer->AdvancedSearch->SearchValue = @$filter["x_Show_Entire_Footer"];
		$this->Show_Entire_Footer->AdvancedSearch->SearchOperator = @$filter["z_Show_Entire_Footer"];
		$this->Show_Entire_Footer->AdvancedSearch->SearchCondition = @$filter["v_Show_Entire_Footer"];
		$this->Show_Entire_Footer->AdvancedSearch->SearchValue2 = @$filter["y_Show_Entire_Footer"];
		$this->Show_Entire_Footer->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Entire_Footer"];
		$this->Show_Entire_Footer->AdvancedSearch->Save();

		// Field Show_Text_In_Footer
		$this->Show_Text_In_Footer->AdvancedSearch->SearchValue = @$filter["x_Show_Text_In_Footer"];
		$this->Show_Text_In_Footer->AdvancedSearch->SearchOperator = @$filter["z_Show_Text_In_Footer"];
		$this->Show_Text_In_Footer->AdvancedSearch->SearchCondition = @$filter["v_Show_Text_In_Footer"];
		$this->Show_Text_In_Footer->AdvancedSearch->SearchValue2 = @$filter["y_Show_Text_In_Footer"];
		$this->Show_Text_In_Footer->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Text_In_Footer"];
		$this->Show_Text_In_Footer->AdvancedSearch->Save();

		// Field Show_Back_To_Top_On_Footer
		$this->Show_Back_To_Top_On_Footer->AdvancedSearch->SearchValue = @$filter["x_Show_Back_To_Top_On_Footer"];
		$this->Show_Back_To_Top_On_Footer->AdvancedSearch->SearchOperator = @$filter["z_Show_Back_To_Top_On_Footer"];
		$this->Show_Back_To_Top_On_Footer->AdvancedSearch->SearchCondition = @$filter["v_Show_Back_To_Top_On_Footer"];
		$this->Show_Back_To_Top_On_Footer->AdvancedSearch->SearchValue2 = @$filter["y_Show_Back_To_Top_On_Footer"];
		$this->Show_Back_To_Top_On_Footer->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Back_To_Top_On_Footer"];
		$this->Show_Back_To_Top_On_Footer->AdvancedSearch->Save();

		// Field Show_Terms_And_Conditions_On_Footer
		$this->Show_Terms_And_Conditions_On_Footer->AdvancedSearch->SearchValue = @$filter["x_Show_Terms_And_Conditions_On_Footer"];
		$this->Show_Terms_And_Conditions_On_Footer->AdvancedSearch->SearchOperator = @$filter["z_Show_Terms_And_Conditions_On_Footer"];
		$this->Show_Terms_And_Conditions_On_Footer->AdvancedSearch->SearchCondition = @$filter["v_Show_Terms_And_Conditions_On_Footer"];
		$this->Show_Terms_And_Conditions_On_Footer->AdvancedSearch->SearchValue2 = @$filter["y_Show_Terms_And_Conditions_On_Footer"];
		$this->Show_Terms_And_Conditions_On_Footer->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Terms_And_Conditions_On_Footer"];
		$this->Show_Terms_And_Conditions_On_Footer->AdvancedSearch->Save();

		// Field Show_About_Us_On_Footer
		$this->Show_About_Us_On_Footer->AdvancedSearch->SearchValue = @$filter["x_Show_About_Us_On_Footer"];
		$this->Show_About_Us_On_Footer->AdvancedSearch->SearchOperator = @$filter["z_Show_About_Us_On_Footer"];
		$this->Show_About_Us_On_Footer->AdvancedSearch->SearchCondition = @$filter["v_Show_About_Us_On_Footer"];
		$this->Show_About_Us_On_Footer->AdvancedSearch->SearchValue2 = @$filter["y_Show_About_Us_On_Footer"];
		$this->Show_About_Us_On_Footer->AdvancedSearch->SearchOperator2 = @$filter["w_Show_About_Us_On_Footer"];
		$this->Show_About_Us_On_Footer->AdvancedSearch->Save();

		// Field Pagination_Position
		$this->Pagination_Position->AdvancedSearch->SearchValue = @$filter["x_Pagination_Position"];
		$this->Pagination_Position->AdvancedSearch->SearchOperator = @$filter["z_Pagination_Position"];
		$this->Pagination_Position->AdvancedSearch->SearchCondition = @$filter["v_Pagination_Position"];
		$this->Pagination_Position->AdvancedSearch->SearchValue2 = @$filter["y_Pagination_Position"];
		$this->Pagination_Position->AdvancedSearch->SearchOperator2 = @$filter["w_Pagination_Position"];
		$this->Pagination_Position->AdvancedSearch->Save();

		// Field Pagination_Style
		$this->Pagination_Style->AdvancedSearch->SearchValue = @$filter["x_Pagination_Style"];
		$this->Pagination_Style->AdvancedSearch->SearchOperator = @$filter["z_Pagination_Style"];
		$this->Pagination_Style->AdvancedSearch->SearchCondition = @$filter["v_Pagination_Style"];
		$this->Pagination_Style->AdvancedSearch->SearchValue2 = @$filter["y_Pagination_Style"];
		$this->Pagination_Style->AdvancedSearch->SearchOperator2 = @$filter["w_Pagination_Style"];
		$this->Pagination_Style->AdvancedSearch->Save();

		// Field Selectable_Records_Per_Page
		$this->Selectable_Records_Per_Page->AdvancedSearch->SearchValue = @$filter["x_Selectable_Records_Per_Page"];
		$this->Selectable_Records_Per_Page->AdvancedSearch->SearchOperator = @$filter["z_Selectable_Records_Per_Page"];
		$this->Selectable_Records_Per_Page->AdvancedSearch->SearchCondition = @$filter["v_Selectable_Records_Per_Page"];
		$this->Selectable_Records_Per_Page->AdvancedSearch->SearchValue2 = @$filter["y_Selectable_Records_Per_Page"];
		$this->Selectable_Records_Per_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Selectable_Records_Per_Page"];
		$this->Selectable_Records_Per_Page->AdvancedSearch->Save();

		// Field Selectable_Groups_Per_Page
		$this->Selectable_Groups_Per_Page->AdvancedSearch->SearchValue = @$filter["x_Selectable_Groups_Per_Page"];
		$this->Selectable_Groups_Per_Page->AdvancedSearch->SearchOperator = @$filter["z_Selectable_Groups_Per_Page"];
		$this->Selectable_Groups_Per_Page->AdvancedSearch->SearchCondition = @$filter["v_Selectable_Groups_Per_Page"];
		$this->Selectable_Groups_Per_Page->AdvancedSearch->SearchValue2 = @$filter["y_Selectable_Groups_Per_Page"];
		$this->Selectable_Groups_Per_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Selectable_Groups_Per_Page"];
		$this->Selectable_Groups_Per_Page->AdvancedSearch->Save();

		// Field Default_Record_Per_Page
		$this->Default_Record_Per_Page->AdvancedSearch->SearchValue = @$filter["x_Default_Record_Per_Page"];
		$this->Default_Record_Per_Page->AdvancedSearch->SearchOperator = @$filter["z_Default_Record_Per_Page"];
		$this->Default_Record_Per_Page->AdvancedSearch->SearchCondition = @$filter["v_Default_Record_Per_Page"];
		$this->Default_Record_Per_Page->AdvancedSearch->SearchValue2 = @$filter["y_Default_Record_Per_Page"];
		$this->Default_Record_Per_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Record_Per_Page"];
		$this->Default_Record_Per_Page->AdvancedSearch->Save();

		// Field Default_Group_Per_Page
		$this->Default_Group_Per_Page->AdvancedSearch->SearchValue = @$filter["x_Default_Group_Per_Page"];
		$this->Default_Group_Per_Page->AdvancedSearch->SearchOperator = @$filter["z_Default_Group_Per_Page"];
		$this->Default_Group_Per_Page->AdvancedSearch->SearchCondition = @$filter["v_Default_Group_Per_Page"];
		$this->Default_Group_Per_Page->AdvancedSearch->SearchValue2 = @$filter["y_Default_Group_Per_Page"];
		$this->Default_Group_Per_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Default_Group_Per_Page"];
		$this->Default_Group_Per_Page->AdvancedSearch->Save();

		// Field Maximum_Selected_Records
		$this->Maximum_Selected_Records->AdvancedSearch->SearchValue = @$filter["x_Maximum_Selected_Records"];
		$this->Maximum_Selected_Records->AdvancedSearch->SearchOperator = @$filter["z_Maximum_Selected_Records"];
		$this->Maximum_Selected_Records->AdvancedSearch->SearchCondition = @$filter["v_Maximum_Selected_Records"];
		$this->Maximum_Selected_Records->AdvancedSearch->SearchValue2 = @$filter["y_Maximum_Selected_Records"];
		$this->Maximum_Selected_Records->AdvancedSearch->SearchOperator2 = @$filter["w_Maximum_Selected_Records"];
		$this->Maximum_Selected_Records->AdvancedSearch->Save();

		// Field Maximum_Selected_Groups
		$this->Maximum_Selected_Groups->AdvancedSearch->SearchValue = @$filter["x_Maximum_Selected_Groups"];
		$this->Maximum_Selected_Groups->AdvancedSearch->SearchOperator = @$filter["z_Maximum_Selected_Groups"];
		$this->Maximum_Selected_Groups->AdvancedSearch->SearchCondition = @$filter["v_Maximum_Selected_Groups"];
		$this->Maximum_Selected_Groups->AdvancedSearch->SearchValue2 = @$filter["y_Maximum_Selected_Groups"];
		$this->Maximum_Selected_Groups->AdvancedSearch->SearchOperator2 = @$filter["w_Maximum_Selected_Groups"];
		$this->Maximum_Selected_Groups->AdvancedSearch->Save();

		// Field Show_PageNum_If_Record_Not_Over_Pagesize
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->AdvancedSearch->SearchValue = @$filter["x_Show_PageNum_If_Record_Not_Over_Pagesize"];
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->AdvancedSearch->SearchOperator = @$filter["z_Show_PageNum_If_Record_Not_Over_Pagesize"];
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->AdvancedSearch->SearchCondition = @$filter["v_Show_PageNum_If_Record_Not_Over_Pagesize"];
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->AdvancedSearch->SearchValue2 = @$filter["y_Show_PageNum_If_Record_Not_Over_Pagesize"];
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->AdvancedSearch->SearchOperator2 = @$filter["w_Show_PageNum_If_Record_Not_Over_Pagesize"];
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->AdvancedSearch->Save();

		// Field Table_Width_Style
		$this->Table_Width_Style->AdvancedSearch->SearchValue = @$filter["x_Table_Width_Style"];
		$this->Table_Width_Style->AdvancedSearch->SearchOperator = @$filter["z_Table_Width_Style"];
		$this->Table_Width_Style->AdvancedSearch->SearchCondition = @$filter["v_Table_Width_Style"];
		$this->Table_Width_Style->AdvancedSearch->SearchValue2 = @$filter["y_Table_Width_Style"];
		$this->Table_Width_Style->AdvancedSearch->SearchOperator2 = @$filter["w_Table_Width_Style"];
		$this->Table_Width_Style->AdvancedSearch->Save();

		// Field Scroll_Table_Width
		$this->Scroll_Table_Width->AdvancedSearch->SearchValue = @$filter["x_Scroll_Table_Width"];
		$this->Scroll_Table_Width->AdvancedSearch->SearchOperator = @$filter["z_Scroll_Table_Width"];
		$this->Scroll_Table_Width->AdvancedSearch->SearchCondition = @$filter["v_Scroll_Table_Width"];
		$this->Scroll_Table_Width->AdvancedSearch->SearchValue2 = @$filter["y_Scroll_Table_Width"];
		$this->Scroll_Table_Width->AdvancedSearch->SearchOperator2 = @$filter["w_Scroll_Table_Width"];
		$this->Scroll_Table_Width->AdvancedSearch->Save();

		// Field Scroll_Table_Height
		$this->Scroll_Table_Height->AdvancedSearch->SearchValue = @$filter["x_Scroll_Table_Height"];
		$this->Scroll_Table_Height->AdvancedSearch->SearchOperator = @$filter["z_Scroll_Table_Height"];
		$this->Scroll_Table_Height->AdvancedSearch->SearchCondition = @$filter["v_Scroll_Table_Height"];
		$this->Scroll_Table_Height->AdvancedSearch->SearchValue2 = @$filter["y_Scroll_Table_Height"];
		$this->Scroll_Table_Height->AdvancedSearch->SearchOperator2 = @$filter["w_Scroll_Table_Height"];
		$this->Scroll_Table_Height->AdvancedSearch->Save();

		// Field Search_Panel_Collapsed
		$this->Search_Panel_Collapsed->AdvancedSearch->SearchValue = @$filter["x_Search_Panel_Collapsed"];
		$this->Search_Panel_Collapsed->AdvancedSearch->SearchOperator = @$filter["z_Search_Panel_Collapsed"];
		$this->Search_Panel_Collapsed->AdvancedSearch->SearchCondition = @$filter["v_Search_Panel_Collapsed"];
		$this->Search_Panel_Collapsed->AdvancedSearch->SearchValue2 = @$filter["y_Search_Panel_Collapsed"];
		$this->Search_Panel_Collapsed->AdvancedSearch->SearchOperator2 = @$filter["w_Search_Panel_Collapsed"];
		$this->Search_Panel_Collapsed->AdvancedSearch->Save();

		// Field Filter_Panel_Collapsed
		$this->Filter_Panel_Collapsed->AdvancedSearch->SearchValue = @$filter["x_Filter_Panel_Collapsed"];
		$this->Filter_Panel_Collapsed->AdvancedSearch->SearchOperator = @$filter["z_Filter_Panel_Collapsed"];
		$this->Filter_Panel_Collapsed->AdvancedSearch->SearchCondition = @$filter["v_Filter_Panel_Collapsed"];
		$this->Filter_Panel_Collapsed->AdvancedSearch->SearchValue2 = @$filter["y_Filter_Panel_Collapsed"];
		$this->Filter_Panel_Collapsed->AdvancedSearch->SearchOperator2 = @$filter["w_Filter_Panel_Collapsed"];
		$this->Filter_Panel_Collapsed->AdvancedSearch->Save();

		// Field Show_Record_Number_On_List_Page
		$this->Show_Record_Number_On_List_Page->AdvancedSearch->SearchValue = @$filter["x_Show_Record_Number_On_List_Page"];
		$this->Show_Record_Number_On_List_Page->AdvancedSearch->SearchOperator = @$filter["z_Show_Record_Number_On_List_Page"];
		$this->Show_Record_Number_On_List_Page->AdvancedSearch->SearchCondition = @$filter["v_Show_Record_Number_On_List_Page"];
		$this->Show_Record_Number_On_List_Page->AdvancedSearch->SearchValue2 = @$filter["y_Show_Record_Number_On_List_Page"];
		$this->Show_Record_Number_On_List_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Record_Number_On_List_Page"];
		$this->Show_Record_Number_On_List_Page->AdvancedSearch->Save();

		// Field Show_Empty_Table_On_List_Page
		$this->Show_Empty_Table_On_List_Page->AdvancedSearch->SearchValue = @$filter["x_Show_Empty_Table_On_List_Page"];
		$this->Show_Empty_Table_On_List_Page->AdvancedSearch->SearchOperator = @$filter["z_Show_Empty_Table_On_List_Page"];
		$this->Show_Empty_Table_On_List_Page->AdvancedSearch->SearchCondition = @$filter["v_Show_Empty_Table_On_List_Page"];
		$this->Show_Empty_Table_On_List_Page->AdvancedSearch->SearchValue2 = @$filter["y_Show_Empty_Table_On_List_Page"];
		$this->Show_Empty_Table_On_List_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Empty_Table_On_List_Page"];
		$this->Show_Empty_Table_On_List_Page->AdvancedSearch->Save();

		// Field Rows_Vertical_Align_Top
		$this->Rows_Vertical_Align_Top->AdvancedSearch->SearchValue = @$filter["x_Rows_Vertical_Align_Top"];
		$this->Rows_Vertical_Align_Top->AdvancedSearch->SearchOperator = @$filter["z_Rows_Vertical_Align_Top"];
		$this->Rows_Vertical_Align_Top->AdvancedSearch->SearchCondition = @$filter["v_Rows_Vertical_Align_Top"];
		$this->Rows_Vertical_Align_Top->AdvancedSearch->SearchValue2 = @$filter["y_Rows_Vertical_Align_Top"];
		$this->Rows_Vertical_Align_Top->AdvancedSearch->SearchOperator2 = @$filter["w_Rows_Vertical_Align_Top"];
		$this->Rows_Vertical_Align_Top->AdvancedSearch->Save();

		// Field Action_Button_Alignment
		$this->Action_Button_Alignment->AdvancedSearch->SearchValue = @$filter["x_Action_Button_Alignment"];
		$this->Action_Button_Alignment->AdvancedSearch->SearchOperator = @$filter["z_Action_Button_Alignment"];
		$this->Action_Button_Alignment->AdvancedSearch->SearchCondition = @$filter["v_Action_Button_Alignment"];
		$this->Action_Button_Alignment->AdvancedSearch->SearchValue2 = @$filter["y_Action_Button_Alignment"];
		$this->Action_Button_Alignment->AdvancedSearch->SearchOperator2 = @$filter["w_Action_Button_Alignment"];
		$this->Action_Button_Alignment->AdvancedSearch->Save();

		// Field Show_Add_Success_Message
		$this->Show_Add_Success_Message->AdvancedSearch->SearchValue = @$filter["x_Show_Add_Success_Message"];
		$this->Show_Add_Success_Message->AdvancedSearch->SearchOperator = @$filter["z_Show_Add_Success_Message"];
		$this->Show_Add_Success_Message->AdvancedSearch->SearchCondition = @$filter["v_Show_Add_Success_Message"];
		$this->Show_Add_Success_Message->AdvancedSearch->SearchValue2 = @$filter["y_Show_Add_Success_Message"];
		$this->Show_Add_Success_Message->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Add_Success_Message"];
		$this->Show_Add_Success_Message->AdvancedSearch->Save();

		// Field Show_Edit_Success_Message
		$this->Show_Edit_Success_Message->AdvancedSearch->SearchValue = @$filter["x_Show_Edit_Success_Message"];
		$this->Show_Edit_Success_Message->AdvancedSearch->SearchOperator = @$filter["z_Show_Edit_Success_Message"];
		$this->Show_Edit_Success_Message->AdvancedSearch->SearchCondition = @$filter["v_Show_Edit_Success_Message"];
		$this->Show_Edit_Success_Message->AdvancedSearch->SearchValue2 = @$filter["y_Show_Edit_Success_Message"];
		$this->Show_Edit_Success_Message->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Edit_Success_Message"];
		$this->Show_Edit_Success_Message->AdvancedSearch->Save();

		// Field jQuery_Auto_Hide_Success_Message
		$this->jQuery_Auto_Hide_Success_Message->AdvancedSearch->SearchValue = @$filter["x_jQuery_Auto_Hide_Success_Message"];
		$this->jQuery_Auto_Hide_Success_Message->AdvancedSearch->SearchOperator = @$filter["z_jQuery_Auto_Hide_Success_Message"];
		$this->jQuery_Auto_Hide_Success_Message->AdvancedSearch->SearchCondition = @$filter["v_jQuery_Auto_Hide_Success_Message"];
		$this->jQuery_Auto_Hide_Success_Message->AdvancedSearch->SearchValue2 = @$filter["y_jQuery_Auto_Hide_Success_Message"];
		$this->jQuery_Auto_Hide_Success_Message->AdvancedSearch->SearchOperator2 = @$filter["w_jQuery_Auto_Hide_Success_Message"];
		$this->jQuery_Auto_Hide_Success_Message->AdvancedSearch->Save();

		// Field Use_Javascript_Message
		$this->Use_Javascript_Message->AdvancedSearch->SearchValue = @$filter["x_Use_Javascript_Message"];
		$this->Use_Javascript_Message->AdvancedSearch->SearchOperator = @$filter["z_Use_Javascript_Message"];
		$this->Use_Javascript_Message->AdvancedSearch->SearchCondition = @$filter["v_Use_Javascript_Message"];
		$this->Use_Javascript_Message->AdvancedSearch->SearchValue2 = @$filter["y_Use_Javascript_Message"];
		$this->Use_Javascript_Message->AdvancedSearch->SearchOperator2 = @$filter["w_Use_Javascript_Message"];
		$this->Use_Javascript_Message->AdvancedSearch->Save();

		// Field Login_Window_Type
		$this->Login_Window_Type->AdvancedSearch->SearchValue = @$filter["x_Login_Window_Type"];
		$this->Login_Window_Type->AdvancedSearch->SearchOperator = @$filter["z_Login_Window_Type"];
		$this->Login_Window_Type->AdvancedSearch->SearchCondition = @$filter["v_Login_Window_Type"];
		$this->Login_Window_Type->AdvancedSearch->SearchValue2 = @$filter["y_Login_Window_Type"];
		$this->Login_Window_Type->AdvancedSearch->SearchOperator2 = @$filter["w_Login_Window_Type"];
		$this->Login_Window_Type->AdvancedSearch->Save();

		// Field Forgot_Password_Window_Type
		$this->Forgot_Password_Window_Type->AdvancedSearch->SearchValue = @$filter["x_Forgot_Password_Window_Type"];
		$this->Forgot_Password_Window_Type->AdvancedSearch->SearchOperator = @$filter["z_Forgot_Password_Window_Type"];
		$this->Forgot_Password_Window_Type->AdvancedSearch->SearchCondition = @$filter["v_Forgot_Password_Window_Type"];
		$this->Forgot_Password_Window_Type->AdvancedSearch->SearchValue2 = @$filter["y_Forgot_Password_Window_Type"];
		$this->Forgot_Password_Window_Type->AdvancedSearch->SearchOperator2 = @$filter["w_Forgot_Password_Window_Type"];
		$this->Forgot_Password_Window_Type->AdvancedSearch->Save();

		// Field Change_Password_Window_Type
		$this->Change_Password_Window_Type->AdvancedSearch->SearchValue = @$filter["x_Change_Password_Window_Type"];
		$this->Change_Password_Window_Type->AdvancedSearch->SearchOperator = @$filter["z_Change_Password_Window_Type"];
		$this->Change_Password_Window_Type->AdvancedSearch->SearchCondition = @$filter["v_Change_Password_Window_Type"];
		$this->Change_Password_Window_Type->AdvancedSearch->SearchValue2 = @$filter["y_Change_Password_Window_Type"];
		$this->Change_Password_Window_Type->AdvancedSearch->SearchOperator2 = @$filter["w_Change_Password_Window_Type"];
		$this->Change_Password_Window_Type->AdvancedSearch->Save();

		// Field Registration_Window_Type
		$this->Registration_Window_Type->AdvancedSearch->SearchValue = @$filter["x_Registration_Window_Type"];
		$this->Registration_Window_Type->AdvancedSearch->SearchOperator = @$filter["z_Registration_Window_Type"];
		$this->Registration_Window_Type->AdvancedSearch->SearchCondition = @$filter["v_Registration_Window_Type"];
		$this->Registration_Window_Type->AdvancedSearch->SearchValue2 = @$filter["y_Registration_Window_Type"];
		$this->Registration_Window_Type->AdvancedSearch->SearchOperator2 = @$filter["w_Registration_Window_Type"];
		$this->Registration_Window_Type->AdvancedSearch->Save();

		// Field Show_Record_Number_On_Detail_Preview
		$this->Show_Record_Number_On_Detail_Preview->AdvancedSearch->SearchValue = @$filter["x_Show_Record_Number_On_Detail_Preview"];
		$this->Show_Record_Number_On_Detail_Preview->AdvancedSearch->SearchOperator = @$filter["z_Show_Record_Number_On_Detail_Preview"];
		$this->Show_Record_Number_On_Detail_Preview->AdvancedSearch->SearchCondition = @$filter["v_Show_Record_Number_On_Detail_Preview"];
		$this->Show_Record_Number_On_Detail_Preview->AdvancedSearch->SearchValue2 = @$filter["y_Show_Record_Number_On_Detail_Preview"];
		$this->Show_Record_Number_On_Detail_Preview->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Record_Number_On_Detail_Preview"];
		$this->Show_Record_Number_On_Detail_Preview->AdvancedSearch->Save();

		// Field Show_Empty_Table_In_Detail_Preview
		$this->Show_Empty_Table_In_Detail_Preview->AdvancedSearch->SearchValue = @$filter["x_Show_Empty_Table_In_Detail_Preview"];
		$this->Show_Empty_Table_In_Detail_Preview->AdvancedSearch->SearchOperator = @$filter["z_Show_Empty_Table_In_Detail_Preview"];
		$this->Show_Empty_Table_In_Detail_Preview->AdvancedSearch->SearchCondition = @$filter["v_Show_Empty_Table_In_Detail_Preview"];
		$this->Show_Empty_Table_In_Detail_Preview->AdvancedSearch->SearchValue2 = @$filter["y_Show_Empty_Table_In_Detail_Preview"];
		$this->Show_Empty_Table_In_Detail_Preview->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Empty_Table_In_Detail_Preview"];
		$this->Show_Empty_Table_In_Detail_Preview->AdvancedSearch->Save();

		// Field Detail_Preview_Table_Width
		$this->Detail_Preview_Table_Width->AdvancedSearch->SearchValue = @$filter["x_Detail_Preview_Table_Width"];
		$this->Detail_Preview_Table_Width->AdvancedSearch->SearchOperator = @$filter["z_Detail_Preview_Table_Width"];
		$this->Detail_Preview_Table_Width->AdvancedSearch->SearchCondition = @$filter["v_Detail_Preview_Table_Width"];
		$this->Detail_Preview_Table_Width->AdvancedSearch->SearchValue2 = @$filter["y_Detail_Preview_Table_Width"];
		$this->Detail_Preview_Table_Width->AdvancedSearch->SearchOperator2 = @$filter["w_Detail_Preview_Table_Width"];
		$this->Detail_Preview_Table_Width->AdvancedSearch->Save();

		// Field Password_Minimum_Length
		$this->Password_Minimum_Length->AdvancedSearch->SearchValue = @$filter["x_Password_Minimum_Length"];
		$this->Password_Minimum_Length->AdvancedSearch->SearchOperator = @$filter["z_Password_Minimum_Length"];
		$this->Password_Minimum_Length->AdvancedSearch->SearchCondition = @$filter["v_Password_Minimum_Length"];
		$this->Password_Minimum_Length->AdvancedSearch->SearchValue2 = @$filter["y_Password_Minimum_Length"];
		$this->Password_Minimum_Length->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Minimum_Length"];
		$this->Password_Minimum_Length->AdvancedSearch->Save();

		// Field Password_Maximum_Length
		$this->Password_Maximum_Length->AdvancedSearch->SearchValue = @$filter["x_Password_Maximum_Length"];
		$this->Password_Maximum_Length->AdvancedSearch->SearchOperator = @$filter["z_Password_Maximum_Length"];
		$this->Password_Maximum_Length->AdvancedSearch->SearchCondition = @$filter["v_Password_Maximum_Length"];
		$this->Password_Maximum_Length->AdvancedSearch->SearchValue2 = @$filter["y_Password_Maximum_Length"];
		$this->Password_Maximum_Length->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Maximum_Length"];
		$this->Password_Maximum_Length->AdvancedSearch->Save();

		// Field Password_Must_Contain_At_Least_One_Lower_Case
		$this->Password_Must_Contain_At_Least_One_Lower_Case->AdvancedSearch->SearchValue = @$filter["x_Password_Must_Contain_At_Least_One_Lower_Case"];
		$this->Password_Must_Contain_At_Least_One_Lower_Case->AdvancedSearch->SearchOperator = @$filter["z_Password_Must_Contain_At_Least_One_Lower_Case"];
		$this->Password_Must_Contain_At_Least_One_Lower_Case->AdvancedSearch->SearchCondition = @$filter["v_Password_Must_Contain_At_Least_One_Lower_Case"];
		$this->Password_Must_Contain_At_Least_One_Lower_Case->AdvancedSearch->SearchValue2 = @$filter["y_Password_Must_Contain_At_Least_One_Lower_Case"];
		$this->Password_Must_Contain_At_Least_One_Lower_Case->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Must_Contain_At_Least_One_Lower_Case"];
		$this->Password_Must_Contain_At_Least_One_Lower_Case->AdvancedSearch->Save();

		// Field Password_Must_Comply_With_Minumum_Length
		$this->Password_Must_Comply_With_Minumum_Length->AdvancedSearch->SearchValue = @$filter["x_Password_Must_Comply_With_Minumum_Length"];
		$this->Password_Must_Comply_With_Minumum_Length->AdvancedSearch->SearchOperator = @$filter["z_Password_Must_Comply_With_Minumum_Length"];
		$this->Password_Must_Comply_With_Minumum_Length->AdvancedSearch->SearchCondition = @$filter["v_Password_Must_Comply_With_Minumum_Length"];
		$this->Password_Must_Comply_With_Minumum_Length->AdvancedSearch->SearchValue2 = @$filter["y_Password_Must_Comply_With_Minumum_Length"];
		$this->Password_Must_Comply_With_Minumum_Length->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Must_Comply_With_Minumum_Length"];
		$this->Password_Must_Comply_With_Minumum_Length->AdvancedSearch->Save();

		// Field Password_Must_Comply_With_Maximum_Length
		$this->Password_Must_Comply_With_Maximum_Length->AdvancedSearch->SearchValue = @$filter["x_Password_Must_Comply_With_Maximum_Length"];
		$this->Password_Must_Comply_With_Maximum_Length->AdvancedSearch->SearchOperator = @$filter["z_Password_Must_Comply_With_Maximum_Length"];
		$this->Password_Must_Comply_With_Maximum_Length->AdvancedSearch->SearchCondition = @$filter["v_Password_Must_Comply_With_Maximum_Length"];
		$this->Password_Must_Comply_With_Maximum_Length->AdvancedSearch->SearchValue2 = @$filter["y_Password_Must_Comply_With_Maximum_Length"];
		$this->Password_Must_Comply_With_Maximum_Length->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Must_Comply_With_Maximum_Length"];
		$this->Password_Must_Comply_With_Maximum_Length->AdvancedSearch->Save();

		// Field Password_Must_Contain_At_Least_One_Upper_Case
		$this->Password_Must_Contain_At_Least_One_Upper_Case->AdvancedSearch->SearchValue = @$filter["x_Password_Must_Contain_At_Least_One_Upper_Case"];
		$this->Password_Must_Contain_At_Least_One_Upper_Case->AdvancedSearch->SearchOperator = @$filter["z_Password_Must_Contain_At_Least_One_Upper_Case"];
		$this->Password_Must_Contain_At_Least_One_Upper_Case->AdvancedSearch->SearchCondition = @$filter["v_Password_Must_Contain_At_Least_One_Upper_Case"];
		$this->Password_Must_Contain_At_Least_One_Upper_Case->AdvancedSearch->SearchValue2 = @$filter["y_Password_Must_Contain_At_Least_One_Upper_Case"];
		$this->Password_Must_Contain_At_Least_One_Upper_Case->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Must_Contain_At_Least_One_Upper_Case"];
		$this->Password_Must_Contain_At_Least_One_Upper_Case->AdvancedSearch->Save();

		// Field Password_Must_Contain_At_Least_One_Numeric
		$this->Password_Must_Contain_At_Least_One_Numeric->AdvancedSearch->SearchValue = @$filter["x_Password_Must_Contain_At_Least_One_Numeric"];
		$this->Password_Must_Contain_At_Least_One_Numeric->AdvancedSearch->SearchOperator = @$filter["z_Password_Must_Contain_At_Least_One_Numeric"];
		$this->Password_Must_Contain_At_Least_One_Numeric->AdvancedSearch->SearchCondition = @$filter["v_Password_Must_Contain_At_Least_One_Numeric"];
		$this->Password_Must_Contain_At_Least_One_Numeric->AdvancedSearch->SearchValue2 = @$filter["y_Password_Must_Contain_At_Least_One_Numeric"];
		$this->Password_Must_Contain_At_Least_One_Numeric->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Must_Contain_At_Least_One_Numeric"];
		$this->Password_Must_Contain_At_Least_One_Numeric->AdvancedSearch->Save();

		// Field Password_Must_Contain_At_Least_One_Symbol
		$this->Password_Must_Contain_At_Least_One_Symbol->AdvancedSearch->SearchValue = @$filter["x_Password_Must_Contain_At_Least_One_Symbol"];
		$this->Password_Must_Contain_At_Least_One_Symbol->AdvancedSearch->SearchOperator = @$filter["z_Password_Must_Contain_At_Least_One_Symbol"];
		$this->Password_Must_Contain_At_Least_One_Symbol->AdvancedSearch->SearchCondition = @$filter["v_Password_Must_Contain_At_Least_One_Symbol"];
		$this->Password_Must_Contain_At_Least_One_Symbol->AdvancedSearch->SearchValue2 = @$filter["y_Password_Must_Contain_At_Least_One_Symbol"];
		$this->Password_Must_Contain_At_Least_One_Symbol->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Must_Contain_At_Least_One_Symbol"];
		$this->Password_Must_Contain_At_Least_One_Symbol->AdvancedSearch->Save();

		// Field Password_Must_Be_Difference_Between_Old_And_New
		$this->Password_Must_Be_Difference_Between_Old_And_New->AdvancedSearch->SearchValue = @$filter["x_Password_Must_Be_Difference_Between_Old_And_New"];
		$this->Password_Must_Be_Difference_Between_Old_And_New->AdvancedSearch->SearchOperator = @$filter["z_Password_Must_Be_Difference_Between_Old_And_New"];
		$this->Password_Must_Be_Difference_Between_Old_And_New->AdvancedSearch->SearchCondition = @$filter["v_Password_Must_Be_Difference_Between_Old_And_New"];
		$this->Password_Must_Be_Difference_Between_Old_And_New->AdvancedSearch->SearchValue2 = @$filter["y_Password_Must_Be_Difference_Between_Old_And_New"];
		$this->Password_Must_Be_Difference_Between_Old_And_New->AdvancedSearch->SearchOperator2 = @$filter["w_Password_Must_Be_Difference_Between_Old_And_New"];
		$this->Password_Must_Be_Difference_Between_Old_And_New->AdvancedSearch->Save();

		// Field Reset_Password_Field_Options
		$this->Reset_Password_Field_Options->AdvancedSearch->SearchValue = @$filter["x_Reset_Password_Field_Options"];
		$this->Reset_Password_Field_Options->AdvancedSearch->SearchOperator = @$filter["z_Reset_Password_Field_Options"];
		$this->Reset_Password_Field_Options->AdvancedSearch->SearchCondition = @$filter["v_Reset_Password_Field_Options"];
		$this->Reset_Password_Field_Options->AdvancedSearch->SearchValue2 = @$filter["y_Reset_Password_Field_Options"];
		$this->Reset_Password_Field_Options->AdvancedSearch->SearchOperator2 = @$filter["w_Reset_Password_Field_Options"];
		$this->Reset_Password_Field_Options->AdvancedSearch->Save();

		// Field Export_Record_Options
		$this->Export_Record_Options->AdvancedSearch->SearchValue = @$filter["x_Export_Record_Options"];
		$this->Export_Record_Options->AdvancedSearch->SearchOperator = @$filter["z_Export_Record_Options"];
		$this->Export_Record_Options->AdvancedSearch->SearchCondition = @$filter["v_Export_Record_Options"];
		$this->Export_Record_Options->AdvancedSearch->SearchValue2 = @$filter["y_Export_Record_Options"];
		$this->Export_Record_Options->AdvancedSearch->SearchOperator2 = @$filter["w_Export_Record_Options"];
		$this->Export_Record_Options->AdvancedSearch->Save();

		// Field Show_Record_Number_On_Exported_List_Page
		$this->Show_Record_Number_On_Exported_List_Page->AdvancedSearch->SearchValue = @$filter["x_Show_Record_Number_On_Exported_List_Page"];
		$this->Show_Record_Number_On_Exported_List_Page->AdvancedSearch->SearchOperator = @$filter["z_Show_Record_Number_On_Exported_List_Page"];
		$this->Show_Record_Number_On_Exported_List_Page->AdvancedSearch->SearchCondition = @$filter["v_Show_Record_Number_On_Exported_List_Page"];
		$this->Show_Record_Number_On_Exported_List_Page->AdvancedSearch->SearchValue2 = @$filter["y_Show_Record_Number_On_Exported_List_Page"];
		$this->Show_Record_Number_On_Exported_List_Page->AdvancedSearch->SearchOperator2 = @$filter["w_Show_Record_Number_On_Exported_List_Page"];
		$this->Show_Record_Number_On_Exported_List_Page->AdvancedSearch->Save();

		// Field Use_Table_Setting_For_Export_Field_Caption
		$this->Use_Table_Setting_For_Export_Field_Caption->AdvancedSearch->SearchValue = @$filter["x_Use_Table_Setting_For_Export_Field_Caption"];
		$this->Use_Table_Setting_For_Export_Field_Caption->AdvancedSearch->SearchOperator = @$filter["z_Use_Table_Setting_For_Export_Field_Caption"];
		$this->Use_Table_Setting_For_Export_Field_Caption->AdvancedSearch->SearchCondition = @$filter["v_Use_Table_Setting_For_Export_Field_Caption"];
		$this->Use_Table_Setting_For_Export_Field_Caption->AdvancedSearch->SearchValue2 = @$filter["y_Use_Table_Setting_For_Export_Field_Caption"];
		$this->Use_Table_Setting_For_Export_Field_Caption->AdvancedSearch->SearchOperator2 = @$filter["w_Use_Table_Setting_For_Export_Field_Caption"];
		$this->Use_Table_Setting_For_Export_Field_Caption->AdvancedSearch->Save();

		// Field Use_Table_Setting_For_Export_Original_Value
		$this->Use_Table_Setting_For_Export_Original_Value->AdvancedSearch->SearchValue = @$filter["x_Use_Table_Setting_For_Export_Original_Value"];
		$this->Use_Table_Setting_For_Export_Original_Value->AdvancedSearch->SearchOperator = @$filter["z_Use_Table_Setting_For_Export_Original_Value"];
		$this->Use_Table_Setting_For_Export_Original_Value->AdvancedSearch->SearchCondition = @$filter["v_Use_Table_Setting_For_Export_Original_Value"];
		$this->Use_Table_Setting_For_Export_Original_Value->AdvancedSearch->SearchValue2 = @$filter["y_Use_Table_Setting_For_Export_Original_Value"];
		$this->Use_Table_Setting_For_Export_Original_Value->AdvancedSearch->SearchOperator2 = @$filter["w_Use_Table_Setting_For_Export_Original_Value"];
		$this->Use_Table_Setting_For_Export_Original_Value->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Default_Theme, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Font_Name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Font_Size, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SMTP_Server, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SMTP_Server_Port, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SMTP_Server_Username, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SMTP_Server_Password, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Sender_Email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Recipient_Email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Default_Language, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Default_Timezone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Default_Thousands_Separator, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Default_Decimal_Point, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Default_Currency_Symbol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Default_Money_Thousands_Separator, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Default_Money_Decimal_Point, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Selectable_Records_Per_Page, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Selectable_Groups_Per_Page, $arKeywords, $type);
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
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Option_ID); // Option_ID
			$this->UpdateSort($this->Option_Default); // Option_Default
			$this->UpdateSort($this->Default_Theme); // Default_Theme
			$this->UpdateSort($this->Show_Border_Layout); // Show_Border_Layout
			$this->UpdateSort($this->Show_Shadow_Layout); // Show_Shadow_Layout
			$this->UpdateSort($this->Menu_Horizontal); // Menu_Horizontal
			$this->UpdateSort($this->Show_Announcement); // Show_Announcement
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Option_ID->setSort("");
				$this->Option_Default->setSort("");
				$this->Default_Theme->setSort("");
				$this->Show_Border_Layout->setSort("");
				$this->Show_Shadow_Layout->setSort("");
				$this->Menu_Horizontal->setSort("");
				$this->Show_Announcement->setSort("");
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

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanDelete();
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

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Option_ID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fsettingslist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fsettingslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fsettingslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fsettingslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
			$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fsettingslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->Option_ID->setDbValue($rs->fields('Option_ID'));
		$this->Option_Default->setDbValue($rs->fields('Option_Default'));
		$this->Default_Theme->setDbValue($rs->fields('Default_Theme'));
		$this->Font_Name->setDbValue($rs->fields('Font_Name'));
		$this->Font_Size->setDbValue($rs->fields('Font_Size'));
		$this->Show_Border_Layout->setDbValue($rs->fields('Show_Border_Layout'));
		$this->Show_Shadow_Layout->setDbValue($rs->fields('Show_Shadow_Layout'));
		$this->Menu_Horizontal->setDbValue($rs->fields('Menu_Horizontal'));
		$this->Vertical_Menu_Width->setDbValue($rs->fields('Vertical_Menu_Width'));
		$this->Show_Announcement->setDbValue($rs->fields('Show_Announcement'));
		$this->Demo_Mode->setDbValue($rs->fields('Demo_Mode'));
		$this->Show_Page_Processing_Time->setDbValue($rs->fields('Show_Page_Processing_Time'));
		$this->Allow_User_Preferences->setDbValue($rs->fields('Allow_User_Preferences'));
		$this->SMTP_Server->setDbValue($rs->fields('SMTP_Server'));
		$this->SMTP_Server_Port->setDbValue($rs->fields('SMTP_Server_Port'));
		$this->SMTP_Server_Username->setDbValue($rs->fields('SMTP_Server_Username'));
		$this->SMTP_Server_Password->setDbValue($rs->fields('SMTP_Server_Password'));
		$this->Sender_Email->setDbValue($rs->fields('Sender_Email'));
		$this->Recipient_Email->setDbValue($rs->fields('Recipient_Email'));
		$this->Use_Default_Locale->setDbValue($rs->fields('Use_Default_Locale'));
		$this->Default_Language->setDbValue($rs->fields('Default_Language'));
		$this->Default_Timezone->setDbValue($rs->fields('Default_Timezone'));
		$this->Default_Thousands_Separator->setDbValue($rs->fields('Default_Thousands_Separator'));
		$this->Default_Decimal_Point->setDbValue($rs->fields('Default_Decimal_Point'));
		$this->Default_Currency_Symbol->setDbValue($rs->fields('Default_Currency_Symbol'));
		$this->Default_Money_Thousands_Separator->setDbValue($rs->fields('Default_Money_Thousands_Separator'));
		$this->Default_Money_Decimal_Point->setDbValue($rs->fields('Default_Money_Decimal_Point'));
		$this->Maintenance_Mode->setDbValue($rs->fields('Maintenance_Mode'));
		$this->Maintenance_Finish_DateTime->setDbValue($rs->fields('Maintenance_Finish_DateTime'));
		$this->Auto_Normal_After_Maintenance->setDbValue($rs->fields('Auto_Normal_After_Maintenance'));
		$this->Allow_User_To_Register->setDbValue($rs->fields('Allow_User_To_Register'));
		$this->Suspend_New_User_Account->setDbValue($rs->fields('Suspend_New_User_Account'));
		$this->User_Need_Activation_After_Registered->setDbValue($rs->fields('User_Need_Activation_After_Registered'));
		$this->Show_Captcha_On_Registration_Page->setDbValue($rs->fields('Show_Captcha_On_Registration_Page'));
		$this->Show_Terms_And_Conditions_On_Registration_Page->setDbValue($rs->fields('Show_Terms_And_Conditions_On_Registration_Page'));
		$this->User_Auto_Login_After_Activation_Or_Registration->setDbValue($rs->fields('User_Auto_Login_After_Activation_Or_Registration'));
		$this->Show_Captcha_On_Login_Page->setDbValue($rs->fields('Show_Captcha_On_Login_Page'));
		$this->Show_Captcha_On_Forgot_Password_Page->setDbValue($rs->fields('Show_Captcha_On_Forgot_Password_Page'));
		$this->Show_Captcha_On_Change_Password_Page->setDbValue($rs->fields('Show_Captcha_On_Change_Password_Page'));
		$this->User_Auto_Logout_After_Idle_In_Minutes->setDbValue($rs->fields('User_Auto_Logout_After_Idle_In_Minutes'));
		$this->User_Login_Maximum_Retry->setDbValue($rs->fields('User_Login_Maximum_Retry'));
		$this->User_Login_Retry_Lockout->setDbValue($rs->fields('User_Login_Retry_Lockout'));
		$this->Redirect_To_Last_Visited_Page_After_Login->setDbValue($rs->fields('Redirect_To_Last_Visited_Page_After_Login'));
		$this->Enable_Password_Expiry->setDbValue($rs->fields('Enable_Password_Expiry'));
		$this->Password_Expiry_In_Days->setDbValue($rs->fields('Password_Expiry_In_Days'));
		$this->Show_Entire_Header->setDbValue($rs->fields('Show_Entire_Header'));
		$this->Logo_Width->setDbValue($rs->fields('Logo_Width'));
		$this->Show_Site_Title_In_Header->setDbValue($rs->fields('Show_Site_Title_In_Header'));
		$this->Show_Current_User_In_Header->setDbValue($rs->fields('Show_Current_User_In_Header'));
		$this->Text_Align_In_Header->setDbValue($rs->fields('Text_Align_In_Header'));
		$this->Site_Title_Text_Style->setDbValue($rs->fields('Site_Title_Text_Style'));
		$this->Language_Selector_Visibility->setDbValue($rs->fields('Language_Selector_Visibility'));
		$this->Language_Selector_Align->setDbValue($rs->fields('Language_Selector_Align'));
		$this->Show_Entire_Footer->setDbValue($rs->fields('Show_Entire_Footer'));
		$this->Show_Text_In_Footer->setDbValue($rs->fields('Show_Text_In_Footer'));
		$this->Show_Back_To_Top_On_Footer->setDbValue($rs->fields('Show_Back_To_Top_On_Footer'));
		$this->Show_Terms_And_Conditions_On_Footer->setDbValue($rs->fields('Show_Terms_And_Conditions_On_Footer'));
		$this->Show_About_Us_On_Footer->setDbValue($rs->fields('Show_About_Us_On_Footer'));
		$this->Pagination_Position->setDbValue($rs->fields('Pagination_Position'));
		$this->Pagination_Style->setDbValue($rs->fields('Pagination_Style'));
		$this->Selectable_Records_Per_Page->setDbValue($rs->fields('Selectable_Records_Per_Page'));
		$this->Selectable_Groups_Per_Page->setDbValue($rs->fields('Selectable_Groups_Per_Page'));
		$this->Default_Record_Per_Page->setDbValue($rs->fields('Default_Record_Per_Page'));
		$this->Default_Group_Per_Page->setDbValue($rs->fields('Default_Group_Per_Page'));
		$this->Maximum_Selected_Records->setDbValue($rs->fields('Maximum_Selected_Records'));
		$this->Maximum_Selected_Groups->setDbValue($rs->fields('Maximum_Selected_Groups'));
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->setDbValue($rs->fields('Show_PageNum_If_Record_Not_Over_Pagesize'));
		$this->Table_Width_Style->setDbValue($rs->fields('Table_Width_Style'));
		$this->Scroll_Table_Width->setDbValue($rs->fields('Scroll_Table_Width'));
		$this->Scroll_Table_Height->setDbValue($rs->fields('Scroll_Table_Height'));
		$this->Search_Panel_Collapsed->setDbValue($rs->fields('Search_Panel_Collapsed'));
		$this->Filter_Panel_Collapsed->setDbValue($rs->fields('Filter_Panel_Collapsed'));
		$this->Show_Record_Number_On_List_Page->setDbValue($rs->fields('Show_Record_Number_On_List_Page'));
		$this->Show_Empty_Table_On_List_Page->setDbValue($rs->fields('Show_Empty_Table_On_List_Page'));
		$this->Rows_Vertical_Align_Top->setDbValue($rs->fields('Rows_Vertical_Align_Top'));
		$this->Action_Button_Alignment->setDbValue($rs->fields('Action_Button_Alignment'));
		$this->Show_Add_Success_Message->setDbValue($rs->fields('Show_Add_Success_Message'));
		$this->Show_Edit_Success_Message->setDbValue($rs->fields('Show_Edit_Success_Message'));
		$this->jQuery_Auto_Hide_Success_Message->setDbValue($rs->fields('jQuery_Auto_Hide_Success_Message'));
		$this->Use_Javascript_Message->setDbValue($rs->fields('Use_Javascript_Message'));
		$this->Login_Window_Type->setDbValue($rs->fields('Login_Window_Type'));
		$this->Forgot_Password_Window_Type->setDbValue($rs->fields('Forgot_Password_Window_Type'));
		$this->Change_Password_Window_Type->setDbValue($rs->fields('Change_Password_Window_Type'));
		$this->Registration_Window_Type->setDbValue($rs->fields('Registration_Window_Type'));
		$this->Show_Record_Number_On_Detail_Preview->setDbValue($rs->fields('Show_Record_Number_On_Detail_Preview'));
		$this->Show_Empty_Table_In_Detail_Preview->setDbValue($rs->fields('Show_Empty_Table_In_Detail_Preview'));
		$this->Detail_Preview_Table_Width->setDbValue($rs->fields('Detail_Preview_Table_Width'));
		$this->Password_Minimum_Length->setDbValue($rs->fields('Password_Minimum_Length'));
		$this->Password_Maximum_Length->setDbValue($rs->fields('Password_Maximum_Length'));
		$this->Password_Must_Contain_At_Least_One_Lower_Case->setDbValue($rs->fields('Password_Must_Contain_At_Least_One_Lower_Case'));
		$this->Password_Must_Comply_With_Minumum_Length->setDbValue($rs->fields('Password_Must_Comply_With_Minumum_Length'));
		$this->Password_Must_Comply_With_Maximum_Length->setDbValue($rs->fields('Password_Must_Comply_With_Maximum_Length'));
		$this->Password_Must_Contain_At_Least_One_Upper_Case->setDbValue($rs->fields('Password_Must_Contain_At_Least_One_Upper_Case'));
		$this->Password_Must_Contain_At_Least_One_Numeric->setDbValue($rs->fields('Password_Must_Contain_At_Least_One_Numeric'));
		$this->Password_Must_Contain_At_Least_One_Symbol->setDbValue($rs->fields('Password_Must_Contain_At_Least_One_Symbol'));
		$this->Password_Must_Be_Difference_Between_Old_And_New->setDbValue($rs->fields('Password_Must_Be_Difference_Between_Old_And_New'));
		$this->Reset_Password_Field_Options->setDbValue($rs->fields('Reset_Password_Field_Options'));
		$this->Export_Record_Options->setDbValue($rs->fields('Export_Record_Options'));
		$this->Show_Record_Number_On_Exported_List_Page->setDbValue($rs->fields('Show_Record_Number_On_Exported_List_Page'));
		$this->Use_Table_Setting_For_Export_Field_Caption->setDbValue($rs->fields('Use_Table_Setting_For_Export_Field_Caption'));
		$this->Use_Table_Setting_For_Export_Original_Value->setDbValue($rs->fields('Use_Table_Setting_For_Export_Original_Value'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Option_ID->DbValue = $row['Option_ID'];
		$this->Option_Default->DbValue = $row['Option_Default'];
		$this->Default_Theme->DbValue = $row['Default_Theme'];
		$this->Font_Name->DbValue = $row['Font_Name'];
		$this->Font_Size->DbValue = $row['Font_Size'];
		$this->Show_Border_Layout->DbValue = $row['Show_Border_Layout'];
		$this->Show_Shadow_Layout->DbValue = $row['Show_Shadow_Layout'];
		$this->Menu_Horizontal->DbValue = $row['Menu_Horizontal'];
		$this->Vertical_Menu_Width->DbValue = $row['Vertical_Menu_Width'];
		$this->Show_Announcement->DbValue = $row['Show_Announcement'];
		$this->Demo_Mode->DbValue = $row['Demo_Mode'];
		$this->Show_Page_Processing_Time->DbValue = $row['Show_Page_Processing_Time'];
		$this->Allow_User_Preferences->DbValue = $row['Allow_User_Preferences'];
		$this->SMTP_Server->DbValue = $row['SMTP_Server'];
		$this->SMTP_Server_Port->DbValue = $row['SMTP_Server_Port'];
		$this->SMTP_Server_Username->DbValue = $row['SMTP_Server_Username'];
		$this->SMTP_Server_Password->DbValue = $row['SMTP_Server_Password'];
		$this->Sender_Email->DbValue = $row['Sender_Email'];
		$this->Recipient_Email->DbValue = $row['Recipient_Email'];
		$this->Use_Default_Locale->DbValue = $row['Use_Default_Locale'];
		$this->Default_Language->DbValue = $row['Default_Language'];
		$this->Default_Timezone->DbValue = $row['Default_Timezone'];
		$this->Default_Thousands_Separator->DbValue = $row['Default_Thousands_Separator'];
		$this->Default_Decimal_Point->DbValue = $row['Default_Decimal_Point'];
		$this->Default_Currency_Symbol->DbValue = $row['Default_Currency_Symbol'];
		$this->Default_Money_Thousands_Separator->DbValue = $row['Default_Money_Thousands_Separator'];
		$this->Default_Money_Decimal_Point->DbValue = $row['Default_Money_Decimal_Point'];
		$this->Maintenance_Mode->DbValue = $row['Maintenance_Mode'];
		$this->Maintenance_Finish_DateTime->DbValue = $row['Maintenance_Finish_DateTime'];
		$this->Auto_Normal_After_Maintenance->DbValue = $row['Auto_Normal_After_Maintenance'];
		$this->Allow_User_To_Register->DbValue = $row['Allow_User_To_Register'];
		$this->Suspend_New_User_Account->DbValue = $row['Suspend_New_User_Account'];
		$this->User_Need_Activation_After_Registered->DbValue = $row['User_Need_Activation_After_Registered'];
		$this->Show_Captcha_On_Registration_Page->DbValue = $row['Show_Captcha_On_Registration_Page'];
		$this->Show_Terms_And_Conditions_On_Registration_Page->DbValue = $row['Show_Terms_And_Conditions_On_Registration_Page'];
		$this->User_Auto_Login_After_Activation_Or_Registration->DbValue = $row['User_Auto_Login_After_Activation_Or_Registration'];
		$this->Show_Captcha_On_Login_Page->DbValue = $row['Show_Captcha_On_Login_Page'];
		$this->Show_Captcha_On_Forgot_Password_Page->DbValue = $row['Show_Captcha_On_Forgot_Password_Page'];
		$this->Show_Captcha_On_Change_Password_Page->DbValue = $row['Show_Captcha_On_Change_Password_Page'];
		$this->User_Auto_Logout_After_Idle_In_Minutes->DbValue = $row['User_Auto_Logout_After_Idle_In_Minutes'];
		$this->User_Login_Maximum_Retry->DbValue = $row['User_Login_Maximum_Retry'];
		$this->User_Login_Retry_Lockout->DbValue = $row['User_Login_Retry_Lockout'];
		$this->Redirect_To_Last_Visited_Page_After_Login->DbValue = $row['Redirect_To_Last_Visited_Page_After_Login'];
		$this->Enable_Password_Expiry->DbValue = $row['Enable_Password_Expiry'];
		$this->Password_Expiry_In_Days->DbValue = $row['Password_Expiry_In_Days'];
		$this->Show_Entire_Header->DbValue = $row['Show_Entire_Header'];
		$this->Logo_Width->DbValue = $row['Logo_Width'];
		$this->Show_Site_Title_In_Header->DbValue = $row['Show_Site_Title_In_Header'];
		$this->Show_Current_User_In_Header->DbValue = $row['Show_Current_User_In_Header'];
		$this->Text_Align_In_Header->DbValue = $row['Text_Align_In_Header'];
		$this->Site_Title_Text_Style->DbValue = $row['Site_Title_Text_Style'];
		$this->Language_Selector_Visibility->DbValue = $row['Language_Selector_Visibility'];
		$this->Language_Selector_Align->DbValue = $row['Language_Selector_Align'];
		$this->Show_Entire_Footer->DbValue = $row['Show_Entire_Footer'];
		$this->Show_Text_In_Footer->DbValue = $row['Show_Text_In_Footer'];
		$this->Show_Back_To_Top_On_Footer->DbValue = $row['Show_Back_To_Top_On_Footer'];
		$this->Show_Terms_And_Conditions_On_Footer->DbValue = $row['Show_Terms_And_Conditions_On_Footer'];
		$this->Show_About_Us_On_Footer->DbValue = $row['Show_About_Us_On_Footer'];
		$this->Pagination_Position->DbValue = $row['Pagination_Position'];
		$this->Pagination_Style->DbValue = $row['Pagination_Style'];
		$this->Selectable_Records_Per_Page->DbValue = $row['Selectable_Records_Per_Page'];
		$this->Selectable_Groups_Per_Page->DbValue = $row['Selectable_Groups_Per_Page'];
		$this->Default_Record_Per_Page->DbValue = $row['Default_Record_Per_Page'];
		$this->Default_Group_Per_Page->DbValue = $row['Default_Group_Per_Page'];
		$this->Maximum_Selected_Records->DbValue = $row['Maximum_Selected_Records'];
		$this->Maximum_Selected_Groups->DbValue = $row['Maximum_Selected_Groups'];
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->DbValue = $row['Show_PageNum_If_Record_Not_Over_Pagesize'];
		$this->Table_Width_Style->DbValue = $row['Table_Width_Style'];
		$this->Scroll_Table_Width->DbValue = $row['Scroll_Table_Width'];
		$this->Scroll_Table_Height->DbValue = $row['Scroll_Table_Height'];
		$this->Search_Panel_Collapsed->DbValue = $row['Search_Panel_Collapsed'];
		$this->Filter_Panel_Collapsed->DbValue = $row['Filter_Panel_Collapsed'];
		$this->Show_Record_Number_On_List_Page->DbValue = $row['Show_Record_Number_On_List_Page'];
		$this->Show_Empty_Table_On_List_Page->DbValue = $row['Show_Empty_Table_On_List_Page'];
		$this->Rows_Vertical_Align_Top->DbValue = $row['Rows_Vertical_Align_Top'];
		$this->Action_Button_Alignment->DbValue = $row['Action_Button_Alignment'];
		$this->Show_Add_Success_Message->DbValue = $row['Show_Add_Success_Message'];
		$this->Show_Edit_Success_Message->DbValue = $row['Show_Edit_Success_Message'];
		$this->jQuery_Auto_Hide_Success_Message->DbValue = $row['jQuery_Auto_Hide_Success_Message'];
		$this->Use_Javascript_Message->DbValue = $row['Use_Javascript_Message'];
		$this->Login_Window_Type->DbValue = $row['Login_Window_Type'];
		$this->Forgot_Password_Window_Type->DbValue = $row['Forgot_Password_Window_Type'];
		$this->Change_Password_Window_Type->DbValue = $row['Change_Password_Window_Type'];
		$this->Registration_Window_Type->DbValue = $row['Registration_Window_Type'];
		$this->Show_Record_Number_On_Detail_Preview->DbValue = $row['Show_Record_Number_On_Detail_Preview'];
		$this->Show_Empty_Table_In_Detail_Preview->DbValue = $row['Show_Empty_Table_In_Detail_Preview'];
		$this->Detail_Preview_Table_Width->DbValue = $row['Detail_Preview_Table_Width'];
		$this->Password_Minimum_Length->DbValue = $row['Password_Minimum_Length'];
		$this->Password_Maximum_Length->DbValue = $row['Password_Maximum_Length'];
		$this->Password_Must_Contain_At_Least_One_Lower_Case->DbValue = $row['Password_Must_Contain_At_Least_One_Lower_Case'];
		$this->Password_Must_Comply_With_Minumum_Length->DbValue = $row['Password_Must_Comply_With_Minumum_Length'];
		$this->Password_Must_Comply_With_Maximum_Length->DbValue = $row['Password_Must_Comply_With_Maximum_Length'];
		$this->Password_Must_Contain_At_Least_One_Upper_Case->DbValue = $row['Password_Must_Contain_At_Least_One_Upper_Case'];
		$this->Password_Must_Contain_At_Least_One_Numeric->DbValue = $row['Password_Must_Contain_At_Least_One_Numeric'];
		$this->Password_Must_Contain_At_Least_One_Symbol->DbValue = $row['Password_Must_Contain_At_Least_One_Symbol'];
		$this->Password_Must_Be_Difference_Between_Old_And_New->DbValue = $row['Password_Must_Be_Difference_Between_Old_And_New'];
		$this->Reset_Password_Field_Options->DbValue = $row['Reset_Password_Field_Options'];
		$this->Export_Record_Options->DbValue = $row['Export_Record_Options'];
		$this->Show_Record_Number_On_Exported_List_Page->DbValue = $row['Show_Record_Number_On_Exported_List_Page'];
		$this->Use_Table_Setting_For_Export_Field_Caption->DbValue = $row['Use_Table_Setting_For_Export_Field_Caption'];
		$this->Use_Table_Setting_For_Export_Original_Value->DbValue = $row['Use_Table_Setting_For_Export_Original_Value'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Option_ID")) <> "")
			$this->Option_ID->CurrentValue = $this->getKey("Option_ID"); // Option_ID
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

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Option_ID
		// Option_Default
		// Default_Theme
		// Font_Name
		// Font_Size
		// Show_Border_Layout
		// Show_Shadow_Layout
		// Menu_Horizontal
		// Vertical_Menu_Width
		// Show_Announcement
		// Demo_Mode
		// Show_Page_Processing_Time
		// Allow_User_Preferences
		// SMTP_Server
		// SMTP_Server_Port
		// SMTP_Server_Username
		// SMTP_Server_Password
		// Sender_Email
		// Recipient_Email
		// Use_Default_Locale
		// Default_Language
		// Default_Timezone
		// Default_Thousands_Separator
		// Default_Decimal_Point
		// Default_Currency_Symbol
		// Default_Money_Thousands_Separator
		// Default_Money_Decimal_Point
		// Maintenance_Mode
		// Maintenance_Finish_DateTime
		// Auto_Normal_After_Maintenance
		// Allow_User_To_Register
		// Suspend_New_User_Account
		// User_Need_Activation_After_Registered
		// Show_Captcha_On_Registration_Page
		// Show_Terms_And_Conditions_On_Registration_Page
		// User_Auto_Login_After_Activation_Or_Registration
		// Show_Captcha_On_Login_Page
		// Show_Captcha_On_Forgot_Password_Page
		// Show_Captcha_On_Change_Password_Page
		// User_Auto_Logout_After_Idle_In_Minutes
		// User_Login_Maximum_Retry
		// User_Login_Retry_Lockout
		// Redirect_To_Last_Visited_Page_After_Login
		// Enable_Password_Expiry
		// Password_Expiry_In_Days
		// Show_Entire_Header
		// Logo_Width
		// Show_Site_Title_In_Header
		// Show_Current_User_In_Header
		// Text_Align_In_Header
		// Site_Title_Text_Style
		// Language_Selector_Visibility
		// Language_Selector_Align
		// Show_Entire_Footer
		// Show_Text_In_Footer
		// Show_Back_To_Top_On_Footer
		// Show_Terms_And_Conditions_On_Footer
		// Show_About_Us_On_Footer
		// Pagination_Position
		// Pagination_Style
		// Selectable_Records_Per_Page
		// Selectable_Groups_Per_Page
		// Default_Record_Per_Page
		// Default_Group_Per_Page
		// Maximum_Selected_Records
		// Maximum_Selected_Groups
		// Show_PageNum_If_Record_Not_Over_Pagesize
		// Table_Width_Style
		// Scroll_Table_Width
		// Scroll_Table_Height
		// Search_Panel_Collapsed
		// Filter_Panel_Collapsed
		// Show_Record_Number_On_List_Page
		// Show_Empty_Table_On_List_Page
		// Rows_Vertical_Align_Top
		// Action_Button_Alignment
		// Show_Add_Success_Message
		// Show_Edit_Success_Message
		// jQuery_Auto_Hide_Success_Message
		// Use_Javascript_Message
		// Login_Window_Type
		// Forgot_Password_Window_Type
		// Change_Password_Window_Type
		// Registration_Window_Type
		// Show_Record_Number_On_Detail_Preview
		// Show_Empty_Table_In_Detail_Preview
		// Detail_Preview_Table_Width
		// Password_Minimum_Length
		// Password_Maximum_Length
		// Password_Must_Contain_At_Least_One_Lower_Case
		// Password_Must_Comply_With_Minumum_Length
		// Password_Must_Comply_With_Maximum_Length
		// Password_Must_Contain_At_Least_One_Upper_Case
		// Password_Must_Contain_At_Least_One_Numeric
		// Password_Must_Contain_At_Least_One_Symbol
		// Password_Must_Be_Difference_Between_Old_And_New
		// Reset_Password_Field_Options
		// Export_Record_Options
		// Show_Record_Number_On_Exported_List_Page
		// Use_Table_Setting_For_Export_Field_Caption
		// Use_Table_Setting_For_Export_Original_Value

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Option_ID
		$this->Option_ID->ViewValue = $this->Option_ID->CurrentValue;
		$this->Option_ID->ViewCustomAttributes = "";

		// Option_Default
		if (ew_ConvertToBool($this->Option_Default->CurrentValue)) {
			$this->Option_Default->ViewValue = $this->Option_Default->FldTagCaption(1) <> "" ? $this->Option_Default->FldTagCaption(1) : "Yes";
		} else {
			$this->Option_Default->ViewValue = $this->Option_Default->FldTagCaption(2) <> "" ? $this->Option_Default->FldTagCaption(2) : "No";
		}
		$this->Option_Default->ViewCustomAttributes = "";

		// Default_Theme
		if (strval($this->Default_Theme->CurrentValue) <> "") {
			$sFilterWrk = "`Theme_ID`" . ew_SearchString("=", $this->Default_Theme->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Theme_ID`, `Theme_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `themes`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Theme_ID`, `Theme_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `themes`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Default_Theme, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Theme_ID`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Default_Theme->ViewValue = $this->Default_Theme->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Default_Theme->ViewValue = $this->Default_Theme->CurrentValue;
			}
		} else {
			$this->Default_Theme->ViewValue = NULL;
		}
		$this->Default_Theme->ViewCustomAttributes = "";

		// Show_Border_Layout
		if (ew_ConvertToBool($this->Show_Border_Layout->CurrentValue)) {
			$this->Show_Border_Layout->ViewValue = $this->Show_Border_Layout->FldTagCaption(2) <> "" ? $this->Show_Border_Layout->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Border_Layout->ViewValue = $this->Show_Border_Layout->FldTagCaption(1) <> "" ? $this->Show_Border_Layout->FldTagCaption(1) : "No";
		}
		$this->Show_Border_Layout->ViewCustomAttributes = "";

		// Show_Shadow_Layout
		if (ew_ConvertToBool($this->Show_Shadow_Layout->CurrentValue)) {
			$this->Show_Shadow_Layout->ViewValue = $this->Show_Shadow_Layout->FldTagCaption(2) <> "" ? $this->Show_Shadow_Layout->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Shadow_Layout->ViewValue = $this->Show_Shadow_Layout->FldTagCaption(1) <> "" ? $this->Show_Shadow_Layout->FldTagCaption(1) : "No";
		}
		$this->Show_Shadow_Layout->ViewCustomAttributes = "";

		// Menu_Horizontal
		if (ew_ConvertToBool($this->Menu_Horizontal->CurrentValue)) {
			$this->Menu_Horizontal->ViewValue = $this->Menu_Horizontal->FldTagCaption(1) <> "" ? $this->Menu_Horizontal->FldTagCaption(1) : "Yes";
		} else {
			$this->Menu_Horizontal->ViewValue = $this->Menu_Horizontal->FldTagCaption(2) <> "" ? $this->Menu_Horizontal->FldTagCaption(2) : "No";
		}
		$this->Menu_Horizontal->ViewCustomAttributes = "";

		// Show_Announcement
		if (ew_ConvertToBool($this->Show_Announcement->CurrentValue)) {
			$this->Show_Announcement->ViewValue = $this->Show_Announcement->FldTagCaption(1) <> "" ? $this->Show_Announcement->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Announcement->ViewValue = $this->Show_Announcement->FldTagCaption(2) <> "" ? $this->Show_Announcement->FldTagCaption(2) : "No";
		}
		$this->Show_Announcement->ViewCustomAttributes = "";

			// Option_ID
			$this->Option_ID->LinkCustomAttributes = "";
			$this->Option_ID->HrefValue = "";
			$this->Option_ID->TooltipValue = "";

			// Option_Default
			$this->Option_Default->LinkCustomAttributes = "";
			$this->Option_Default->HrefValue = "";
			$this->Option_Default->TooltipValue = "";

			// Default_Theme
			$this->Default_Theme->LinkCustomAttributes = "";
			$this->Default_Theme->HrefValue = "";
			$this->Default_Theme->TooltipValue = "";

			// Show_Border_Layout
			$this->Show_Border_Layout->LinkCustomAttributes = "";
			$this->Show_Border_Layout->HrefValue = "";
			$this->Show_Border_Layout->TooltipValue = "";

			// Show_Shadow_Layout
			$this->Show_Shadow_Layout->LinkCustomAttributes = "";
			$this->Show_Shadow_Layout->HrefValue = "";
			$this->Show_Shadow_Layout->TooltipValue = "";

			// Menu_Horizontal
			$this->Menu_Horizontal->LinkCustomAttributes = "";
			$this->Menu_Horizontal->HrefValue = "";
			$this->Menu_Horizontal->TooltipValue = "";

			// Show_Announcement
			$this->Show_Announcement->LinkCustomAttributes = "";
			$this->Show_Announcement->HrefValue = "";
			$this->Show_Announcement->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
        global $Language, $Security, $settings; // <-- Added $Security variable by Masino Sinaga

		// Printer friendly
        if ($Security->CanExportToPrint() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("print");

			// $item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

			if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
				$item->Body = "<a class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" onclick=\"ew_Export(document.fsettingslist,'" . ew_CurrentPage() . "','print',false,true);\">" . $Language->Phrase("PrinterFriendly") . "</a>";
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
				$item->Body = "<a class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" onclick=\"ew_Export(document.fsettingslist,'" . ew_CurrentPage() . "','excel',false,true);\">" . $Language->Phrase("ExportToExcel") . "</a>";
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
				$item->Body = "<a class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" onclick=\"ew_Export(document.fsettingslist,'" . ew_CurrentPage() . "','word',false,true);\">" . $Language->Phrase("ExportToWord") . "</a>";
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
				$item->Body = "<a class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" onclick=\"ew_Export(document.fsettingslist,'" . ew_CurrentPage() . "','html',false,true);\">" . $Language->Phrase("ExportToHtml") . "</a>";
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
				$item->Body = "<a class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" onclick=\"ew_Export(document.fsettingslist,'" . ew_CurrentPage() . "','xml',false,true);\">" . $Language->Phrase("ExportToXml") . "</a>";
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
				$item->Body = "<a class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" onclick=\"ew_Export(document.fsettingslist,'" . ew_CurrentPage() . "','csv',false,true);\">" . $Language->Phrase("ExportToCsv") . "</a>";
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
				$item->Body = "<a class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" onclick=\"ew_Export(document.fsettingslist,'" . ew_CurrentPage() . "','pdf',false,true);\">" . $Language->Phrase("ExportToPDF") . "</a>";
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

			// $item->Body = "<button id=\"emf_settings\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_settings',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fsettingslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

		if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") {
			$item->Body = "<a id=\"emf_settings\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\"  data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_settings',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fsettingslist,sel:true});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		} else {
			$item->Body = "<a id=\"emf_settings\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\"  data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_settings',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fsettingslist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($settings_list)) $settings_list = new csettings_list();

// Page init
$settings_list->Page_Init();

// Page main
$settings_list->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$settings_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fsettingslist = new ew_Form("fsettingslist", "list");
fsettingslist.FormKeyCountName = '<?php echo $settings_list->FormKeyCountName ?>';

// Form_CustomValidate event
fsettingslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsettingslist.ValidateRequired = true;
<?php } else { ?>
fsettingslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsettingslist.Lists["x_Option_Default[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingslist.Lists["x_Option_Default[]"].Options = <?php echo json_encode($settings->Option_Default->Options()) ?>;
fsettingslist.Lists["x_Default_Theme"] = {"LinkField":"x_Theme_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Theme_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingslist.Lists["x_Show_Border_Layout[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingslist.Lists["x_Show_Border_Layout[]"].Options = <?php echo json_encode($settings->Show_Border_Layout->Options()) ?>;
fsettingslist.Lists["x_Show_Shadow_Layout[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingslist.Lists["x_Show_Shadow_Layout[]"].Options = <?php echo json_encode($settings->Show_Shadow_Layout->Options()) ?>;
fsettingslist.Lists["x_Menu_Horizontal[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingslist.Lists["x_Menu_Horizontal[]"].Options = <?php echo json_encode($settings->Menu_Horizontal->Options()) ?>;
fsettingslist.Lists["x_Show_Announcement"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingslist.Lists["x_Show_Announcement"].Options = <?php echo json_encode($settings->Show_Announcement->Options()) ?>;

// Form object for search
var CurrentSearchForm = fsettingslistsrch = new ew_Form("fsettingslistsrch");

// Init search panel as collapsed
<?php if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_COLLAPSED) { ?>
if (fsettingslistsrch) fsettingslistsrch.InitSearchPanel = true;
<?php } else { ?>
<?php if (MS_SEARCH_PANEL_COLLAPSED == TRUE && CurrentPage()->SearchWhere == "") { ?>
if (fsettingslistsrch) fsettingslistsrch.InitSearchPanel = true;
<?php } elseif ( (MS_SEARCH_PANEL_COLLAPSED == TRUE && CurrentPage()->SearchWhere <> "") || (MS_SEARCH_PANEL_COLLAPSED == FALSE && CurrentPage()->SearchWhere == "") ) { ?>
if (fsettingslistsrch) fsettingslistsrch.InitSearchPanel = false;
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
<?php if ($settings->Export == "") { ?>
<?php $bShowLangSelector = false; ?>
<div class="ewToolbar">
<?php if ($settings->Export == "") { ?>
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php } ?>
<?php if ($settings_list->TotalRecs > 0 && $settings_list->ExportOptions->Visible()) { ?>
<?php $settings_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($bShowLangSelector == false) { ?>
<?php if ($settings_list->SearchOptions->Visible()) { ?>
<?php $settings_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($settings_list->FilterOptions->Visible()) { ?>
<?php $settings_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($settings->Export == "") { ?>
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
	$bSelectLimit = $settings_list->UseSelectLimit;
	if ($bSelectLimit) { // begin of v11.0.4
		if ($settings_list->TotalRecs <= 0)
			$settings_list->TotalRecs = $settings->SelectRecordCount();
	} else {
		if (!$settings_list->Recordset && ($settings_list->Recordset = $settings_list->LoadRecordset()))
			$settings_list->TotalRecs = $settings_list->Recordset->RecordCount();
	} // end of v11.0.4
	$settings_list->StartRec = 1;

// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012     
    if ($settings_list->DisplayRecs <= 0 || ($settings->Export <> "" && $settings->ExportAll=="allpages")) // Display all records
        $settings_list->DisplayRecs = $settings_list->TotalRecs;
    if (!($settings->Export <> "" && $settings->ExportAll=="allpages"))
        $settings_list->SetUpStartRec(); // Set up start record position

// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
	if ($bSelectLimit)
		$settings_list->Recordset = $settings_list->LoadRecordset($settings_list->StartRec-1, $settings_list->DisplayRecs);

	// Set no record found message
	if ($settings->CurrentAction == "" && $settings_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$settings_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($settings_list->SearchWhere == "0=101")
			$settings_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$settings_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$settings_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($settings->Export == "" && $settings->CurrentAction == "") { ?>
<form name="fsettingslistsrch" id="fsettingslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($settings_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fsettingslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="settings">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($settings_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($settings_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $settings_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($settings_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($settings_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($settings_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($settings_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $settings_list->ShowPageHeader(); ?>
<?php
$settings_list->ShowMessage();
?>
<?php //////////////////////////// BEGIN Empty Table ?>
<?php // Begin of modification Displaying Empty Table, by Masino Sinaga, May 3, 2012 ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE) { ?>
<?php if ($settings_list->TotalRecs == 0) { ?>
<div class="panel panel-default ewGrid">
<?php if (MS_PAGINATION_POSITION == 1 || MS_PAGINATION_POSITION == 3) { ?>
<div class="panel-heading ewGridUpperPanel" style="height: 40px;">
<?php if ($settings_list->TotalRecs == 0 && $settings->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($settings_list->OtherOptions as &$option) {
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
<div id="gmp_settings_empty_table" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_settingslist" class="table ewTable">
<?php echo $settings->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($settings->Option_ID->Visible) { // Option_ID ?>
	<?php if ($settings->SortUrl($settings->Option_ID) == "") { ?>
		<th data-name="Option_ID"><div id="elh_settings_Option_ID" class="settings_Option_ID"><div class="ewTableHeaderCaption"><?php echo $settings->Option_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Option_ID"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Option_ID) ?>',1);"><div id="elh_settings_Option_ID" class="settings_Option_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Option_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Option_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Option_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Option_Default->Visible) { // Option_Default ?>
	<?php if ($settings->SortUrl($settings->Option_Default) == "") { ?>
		<th data-name="Option_Default"><div id="elh_settings_Option_Default" class="settings_Option_Default"><div class="ewTableHeaderCaption"><?php echo $settings->Option_Default->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Option_Default"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Option_Default) ?>',1);"><div id="elh_settings_Option_Default" class="settings_Option_Default">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Option_Default->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Option_Default->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Option_Default->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Default_Theme->Visible) { // Default_Theme ?>
	<?php if ($settings->SortUrl($settings->Default_Theme) == "") { ?>
		<th data-name="Default_Theme"><div id="elh_settings_Default_Theme" class="settings_Default_Theme"><div class="ewTableHeaderCaption"><?php echo $settings->Default_Theme->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Default_Theme"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Default_Theme) ?>',1);"><div id="elh_settings_Default_Theme" class="settings_Default_Theme">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Default_Theme->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Default_Theme->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Default_Theme->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Show_Border_Layout->Visible) { // Show_Border_Layout ?>
	<?php if ($settings->SortUrl($settings->Show_Border_Layout) == "") { ?>
		<th data-name="Show_Border_Layout"><div id="elh_settings_Show_Border_Layout" class="settings_Show_Border_Layout"><div class="ewTableHeaderCaption"><?php echo $settings->Show_Border_Layout->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Show_Border_Layout"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Show_Border_Layout) ?>',1);"><div id="elh_settings_Show_Border_Layout" class="settings_Show_Border_Layout">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Show_Border_Layout->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Show_Border_Layout->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Show_Border_Layout->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Show_Shadow_Layout->Visible) { // Show_Shadow_Layout ?>
	<?php if ($settings->SortUrl($settings->Show_Shadow_Layout) == "") { ?>
		<th data-name="Show_Shadow_Layout"><div id="elh_settings_Show_Shadow_Layout" class="settings_Show_Shadow_Layout"><div class="ewTableHeaderCaption"><?php echo $settings->Show_Shadow_Layout->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Show_Shadow_Layout"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Show_Shadow_Layout) ?>',1);"><div id="elh_settings_Show_Shadow_Layout" class="settings_Show_Shadow_Layout">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Show_Shadow_Layout->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Show_Shadow_Layout->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Show_Shadow_Layout->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Menu_Horizontal->Visible) { // Menu_Horizontal ?>
	<?php if ($settings->SortUrl($settings->Menu_Horizontal) == "") { ?>
		<th data-name="Menu_Horizontal"><div id="elh_settings_Menu_Horizontal" class="settings_Menu_Horizontal"><div class="ewTableHeaderCaption"><?php echo $settings->Menu_Horizontal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Menu_Horizontal"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Menu_Horizontal) ?>',1);"><div id="elh_settings_Menu_Horizontal" class="settings_Menu_Horizontal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Menu_Horizontal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Menu_Horizontal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Menu_Horizontal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Show_Announcement->Visible) { // Show_Announcement ?>
	<?php if ($settings->SortUrl($settings->Show_Announcement) == "") { ?>
		<th data-name="Show_Announcement"><div id="elh_settings_Show_Announcement" class="settings_Show_Announcement"><div class="ewTableHeaderCaption"><?php echo $settings->Show_Announcement->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Show_Announcement"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Show_Announcement) ?>',1);"><div id="elh_settings_Show_Announcement" class="settings_Show_Announcement">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Show_Announcement->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Show_Announcement->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Show_Announcement->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
	</tr>
</thead>
<tbody>
	<tr<?php echo $settings->RowAttributes() ?>>
	<?php if ($settings->Option_ID->Visible) { // Option_ID ?>
		<td data-name="Option_ID"<?php echo $settings->Option_ID->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Option_ID" class="settings_Option_ID">
<span<?php echo $settings->Option_ID->ViewAttributes() ?>>
<?php echo $settings->Option_ID->ListViewValue() ?></span>
</span>
<a id="<?php echo $settings_list->PageObjName . "_row_" . $settings_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($settings->Option_Default->Visible) { // Option_Default ?>
		<td data-name="Option_Default"<?php echo $settings->Option_Default->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Option_Default" class="settings_Option_Default">
<span<?php echo $settings->Option_Default->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Option_Default->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Option_Default->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Option_Default->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Default_Theme->Visible) { // Default_Theme ?>
		<td data-name="Default_Theme"<?php echo $settings->Default_Theme->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Default_Theme" class="settings_Default_Theme">
<span<?php echo $settings->Default_Theme->ViewAttributes() ?>>
<?php echo $settings->Default_Theme->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Show_Border_Layout->Visible) { // Show_Border_Layout ?>
		<td data-name="Show_Border_Layout"<?php echo $settings->Show_Border_Layout->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Show_Border_Layout" class="settings_Show_Border_Layout">
<span<?php echo $settings->Show_Border_Layout->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Border_Layout->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Border_Layout->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Border_Layout->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Show_Shadow_Layout->Visible) { // Show_Shadow_Layout ?>
		<td data-name="Show_Shadow_Layout"<?php echo $settings->Show_Shadow_Layout->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Show_Shadow_Layout" class="settings_Show_Shadow_Layout">
<span<?php echo $settings->Show_Shadow_Layout->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Shadow_Layout->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Shadow_Layout->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Shadow_Layout->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Menu_Horizontal->Visible) { // Menu_Horizontal ?>
		<td data-name="Menu_Horizontal"<?php echo $settings->Menu_Horizontal->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Menu_Horizontal" class="settings_Menu_Horizontal">
<span<?php echo $settings->Menu_Horizontal->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Menu_Horizontal->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Menu_Horizontal->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Menu_Horizontal->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Show_Announcement->Visible) { // Show_Announcement ?>
		<td data-name="Show_Announcement"<?php echo $settings->Show_Announcement->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Show_Announcement" class="settings_Show_Announcement">
<span<?php echo $settings->Show_Announcement->ViewAttributes() ?>>
<?php echo $settings->Show_Announcement->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	</tr>
</tbody>
</table>
</div>
<?php if (MS_PAGINATION_POSITION == 2 || MS_PAGINATION_POSITION == 3) { ?>
<div class="panel-footer ewGridLowerPanel" style="height: 40px;">
<?php if ($settings_list->TotalRecs == 0 && $settings->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($settings_list->OtherOptions as &$option) {
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
<?php if ($settings_list->TotalRecs > 0 || $settings->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<?php if ($settings->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($settings->CurrentAction <> "gridadd" && $settings->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if ($settings_list->TotalRecs > 0) { ?>
<?php if ( (MS_SELECTABLE_PAGE_SIZES_POSITION=="Left" && $Language->Phrase("dir")!="rtl") || (MS_SELECTABLE_PAGE_SIZES_POSITION=="Left" && $Language->Phrase("dir")=="rtl") ) { ?>
<div class="ewPager"><span>&nbsp;<?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</span>
<input type="hidden" name="t" value="settings">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<?php $sRecPerPageList = explode(',', MS_TABLE_SELECTABLE_REC_PER_PAGE_LIST); ?>
<?php
foreach ($sRecPerPageList as $a) {
 $thisDisplayRecs = $a;
 if ($thisDisplayRecs > 0 ) {
   $thisValue = $thisDisplayRecs;  
?>
<option value="<?php echo $thisDisplayRecs; ?>"<?php if ($settings_list->DisplayRecs == $thisValue) { ?> selected="selected"<?php } ?>><?php echo $thisDisplayRecs; ?></option>
<?php	} else { ?>
<option value="ALL"<?php if ($settings->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
<?php
		}
	}
?>
</select>
</div>
<?php } ?>
<?php } ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($settings_list->Pager)) $settings_list->Pager = new cNumericPager($settings_list->StartRec, $settings_list->DisplayRecs, $settings_list->TotalRecs, $settings_list->RecRange) ?>
		<?php if ($settings_list->Pager->RecordCount > 0) { ?>
				<?php if (($settings_list->Pager->PageCount==1) && ($settings_list->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($settings_list->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_list->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($settings_list->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $settings_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($settings_list->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_list->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $settings_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $settings_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $settings_list->Pager->RecordCount ?></span>
				</div>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($settings_list->Pager)) $settings_list->Pager = new cPrevNextPager($settings_list->StartRec, $settings_list->DisplayRecs, $settings_list->TotalRecs) ?>
		<?php if ($settings_list->Pager->RecordCount > 0) { ?>
				<?php if (($settings_list->Pager->PageCount==1) && ($settings_list->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($settings_list->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($settings_list->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $settings_list->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($settings_list->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($settings_list->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $settings_list->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $settings_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $settings_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $settings_list->Pager->RecordCount ?></span>
				</div>
		<?php } ?>
	<?php } // end of link or button ?>	
<?php if ($settings_list->TotalRecs > 0) { ?>
<?php if ( (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right" && $Language->Phrase("dir")!="rtl") || (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right" && $Language->Phrase("dir")=="rtl") ) { ?>
<div class="ewPager"><span>&nbsp;<?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</span>
<input type="hidden" name="t" value="settings">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="1"<?php if ($settings_list->DisplayRecs == 1) { ?> selected="selected"<?php } ?>>1</option>
<option value="3"<?php if ($settings_list->DisplayRecs == 3) { ?> selected="selected"<?php } ?>>3</option>
<option value="5"<?php if ($settings_list->DisplayRecs == 5) { ?> selected="selected"<?php } ?>>5</option>
<option value="10"<?php if ($settings_list->DisplayRecs == 10) { ?> selected="selected"<?php } ?>>10</option>
<option value="20"<?php if ($settings_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($settings_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($settings_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
</select>
</div>
<?php } // end if (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right") ?>
<?php } // end TotalRecs ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($settings_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fsettingslist" id="fsettingslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($settings_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $settings_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="settings">
<?php // Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012 ?>
<?php if (MS_EXPORT_RECORD_OPTIONS=="selectedrecords") { ?>
<input type="hidden" name="exporttype" id="exporttype" value="">
<?php } ?>
<?php // End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012 ?>
<div id="gmp_settings" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($settings_list->TotalRecs > 0) { ?>
<table id="tbl_settingslist" class="table ewTable">
<?php echo $settings->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$settings_list->RowType = EW_ROWTYPE_HEADER; // since v11.0.6

// Render list options
$settings_list->RenderListOptions();

// Render list options (header, left)
$settings_list->ListOptions->Render("header", "left");
?>
<?php if ($settings->Option_ID->Visible) { // Option_ID ?>
	<?php if ($settings->SortUrl($settings->Option_ID) == "") { ?>
		<th data-name="Option_ID"><div id="elh_settings_Option_ID" class="settings_Option_ID"><div class="ewTableHeaderCaption"><?php echo $settings->Option_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Option_ID"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Option_ID) ?>',1);"><div id="elh_settings_Option_ID" class="settings_Option_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Option_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Option_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Option_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Option_Default->Visible) { // Option_Default ?>
	<?php if ($settings->SortUrl($settings->Option_Default) == "") { ?>
		<th data-name="Option_Default"><div id="elh_settings_Option_Default" class="settings_Option_Default"><div class="ewTableHeaderCaption"><?php echo $settings->Option_Default->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Option_Default"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Option_Default) ?>',1);"><div id="elh_settings_Option_Default" class="settings_Option_Default">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Option_Default->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Option_Default->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Option_Default->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Default_Theme->Visible) { // Default_Theme ?>
	<?php if ($settings->SortUrl($settings->Default_Theme) == "") { ?>
		<th data-name="Default_Theme"><div id="elh_settings_Default_Theme" class="settings_Default_Theme"><div class="ewTableHeaderCaption"><?php echo $settings->Default_Theme->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Default_Theme"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Default_Theme) ?>',1);"><div id="elh_settings_Default_Theme" class="settings_Default_Theme">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Default_Theme->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Default_Theme->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Default_Theme->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Show_Border_Layout->Visible) { // Show_Border_Layout ?>
	<?php if ($settings->SortUrl($settings->Show_Border_Layout) == "") { ?>
		<th data-name="Show_Border_Layout"><div id="elh_settings_Show_Border_Layout" class="settings_Show_Border_Layout"><div class="ewTableHeaderCaption"><?php echo $settings->Show_Border_Layout->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Show_Border_Layout"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Show_Border_Layout) ?>',1);"><div id="elh_settings_Show_Border_Layout" class="settings_Show_Border_Layout">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Show_Border_Layout->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Show_Border_Layout->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Show_Border_Layout->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Show_Shadow_Layout->Visible) { // Show_Shadow_Layout ?>
	<?php if ($settings->SortUrl($settings->Show_Shadow_Layout) == "") { ?>
		<th data-name="Show_Shadow_Layout"><div id="elh_settings_Show_Shadow_Layout" class="settings_Show_Shadow_Layout"><div class="ewTableHeaderCaption"><?php echo $settings->Show_Shadow_Layout->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Show_Shadow_Layout"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Show_Shadow_Layout) ?>',1);"><div id="elh_settings_Show_Shadow_Layout" class="settings_Show_Shadow_Layout">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Show_Shadow_Layout->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Show_Shadow_Layout->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Show_Shadow_Layout->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Menu_Horizontal->Visible) { // Menu_Horizontal ?>
	<?php if ($settings->SortUrl($settings->Menu_Horizontal) == "") { ?>
		<th data-name="Menu_Horizontal"><div id="elh_settings_Menu_Horizontal" class="settings_Menu_Horizontal"><div class="ewTableHeaderCaption"><?php echo $settings->Menu_Horizontal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Menu_Horizontal"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Menu_Horizontal) ?>',1);"><div id="elh_settings_Menu_Horizontal" class="settings_Menu_Horizontal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Menu_Horizontal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Menu_Horizontal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Menu_Horizontal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($settings->Show_Announcement->Visible) { // Show_Announcement ?>
	<?php if ($settings->SortUrl($settings->Show_Announcement) == "") { ?>
		<th data-name="Show_Announcement"><div id="elh_settings_Show_Announcement" class="settings_Show_Announcement"><div class="ewTableHeaderCaption"><?php echo $settings->Show_Announcement->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Show_Announcement"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $settings->SortUrl($settings->Show_Announcement) ?>',1);"><div id="elh_settings_Show_Announcement" class="settings_Show_Announcement">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $settings->Show_Announcement->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($settings->Show_Announcement->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($settings->Show_Announcement->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$settings_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php

// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
if ($settings->ExportAll=="allpages" && $settings->Export <> "") {
    $settings_list->StopRec = $settings_list->TotalRecs;

// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
} else {

	// Set the last record to display
	if ($settings_list->TotalRecs > $settings_list->StartRec + $settings_list->DisplayRecs - 1)
		$settings_list->StopRec = $settings_list->StartRec + $settings_list->DisplayRecs - 1;
	else
		$settings_list->StopRec = $settings_list->TotalRecs;
}
$settings_list->RecCnt = $settings_list->StartRec - 1;
if ($settings_list->Recordset && !$settings_list->Recordset->EOF) {
	$settings_list->Recordset->MoveFirst();
	$bSelectLimit = $settings_list->UseSelectLimit;
	if (!$bSelectLimit && $settings_list->StartRec > 1)
		$settings_list->Recordset->Move($settings_list->StartRec - 1);
} elseif (!$settings->AllowAddDeleteRow && $settings_list->StopRec == 0) {
	$settings_list->StopRec = $settings->GridAddRowCount;
}

// Initialize aggregate
$settings->RowType = EW_ROWTYPE_AGGREGATEINIT;
$settings->ResetAttrs();
$settings_list->RenderRow();
while ($settings_list->RecCnt < $settings_list->StopRec) {
	$settings_list->RecCnt++;
	if (intval($settings_list->RecCnt) >= intval($settings_list->StartRec)) {
		$settings_list->RowCnt++;

		// Set up key count
		$settings_list->KeyCount = $settings_list->RowIndex;

		// Init row class and style
		$settings->ResetAttrs();
		$settings->CssClass = "";
		if ($settings->CurrentAction == "gridadd") {
		} else {
			$settings_list->LoadRowValues($settings_list->Recordset); // Load row values
		}
		$settings->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$settings->RowAttrs = array_merge($settings->RowAttrs, array('data-rowindex'=>$settings_list->RowCnt, 'id'=>'r' . $settings_list->RowCnt . '_settings', 'data-rowtype'=>$settings->RowType));

		// Render row
		$settings_list->RenderRow();

		// Render list options
		$settings_list->RenderListOptions();
?>
	<tr<?php echo $settings->RowAttributes() ?>>
<?php

// Render list options (body, left)
$settings_list->ListOptions->Render("body", "left", $settings_list->RowCnt);
?>
	<?php if ($settings->Option_ID->Visible) { // Option_ID ?>
		<td data-name="Option_ID"<?php echo $settings->Option_ID->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Option_ID" class="settings_Option_ID">
<span<?php echo $settings->Option_ID->ViewAttributes() ?>>
<?php echo $settings->Option_ID->ListViewValue() ?></span>
</span>
<a id="<?php echo $settings_list->PageObjName . "_row_" . $settings_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($settings->Option_Default->Visible) { // Option_Default ?>
		<td data-name="Option_Default"<?php echo $settings->Option_Default->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Option_Default" class="settings_Option_Default">
<span<?php echo $settings->Option_Default->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Option_Default->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Option_Default->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Option_Default->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Default_Theme->Visible) { // Default_Theme ?>
		<td data-name="Default_Theme"<?php echo $settings->Default_Theme->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Default_Theme" class="settings_Default_Theme">
<span<?php echo $settings->Default_Theme->ViewAttributes() ?>>
<?php echo $settings->Default_Theme->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Show_Border_Layout->Visible) { // Show_Border_Layout ?>
		<td data-name="Show_Border_Layout"<?php echo $settings->Show_Border_Layout->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Show_Border_Layout" class="settings_Show_Border_Layout">
<span<?php echo $settings->Show_Border_Layout->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Border_Layout->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Border_Layout->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Border_Layout->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Show_Shadow_Layout->Visible) { // Show_Shadow_Layout ?>
		<td data-name="Show_Shadow_Layout"<?php echo $settings->Show_Shadow_Layout->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Show_Shadow_Layout" class="settings_Show_Shadow_Layout">
<span<?php echo $settings->Show_Shadow_Layout->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Shadow_Layout->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Shadow_Layout->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Shadow_Layout->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Menu_Horizontal->Visible) { // Menu_Horizontal ?>
		<td data-name="Menu_Horizontal"<?php echo $settings->Menu_Horizontal->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Menu_Horizontal" class="settings_Menu_Horizontal">
<span<?php echo $settings->Menu_Horizontal->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Menu_Horizontal->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Menu_Horizontal->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Menu_Horizontal->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($settings->Show_Announcement->Visible) { // Show_Announcement ?>
		<td data-name="Show_Announcement"<?php echo $settings->Show_Announcement->CellAttributes() ?>>
<span id="el<?php echo $settings_list->RowCnt ?>_settings_Show_Announcement" class="settings_Show_Announcement">
<span<?php echo $settings->Show_Announcement->ViewAttributes() ?>>
<?php echo $settings->Show_Announcement->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$settings_list->ListOptions->Render("body", "right", $settings_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($settings->CurrentAction <> "gridadd")
		$settings_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($settings->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($settings_list->Recordset)
	$settings_list->Recordset->Close();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
<?php if ($settings->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($settings->CurrentAction <> "gridadd" && $settings->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if ($settings_list->TotalRecs > 0) { ?>
<?php if ( (MS_SELECTABLE_PAGE_SIZES_POSITION=="Left" && $Language->Phrase("dir")!="rtl") || (MS_SELECTABLE_PAGE_SIZES_POSITION=="Left" && $Language->Phrase("dir")=="rtl") ) { ?>
<div class="ewPager"><span>&nbsp;<?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</span>
<input type="hidden" name="t" value="settings">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<?php $sRecPerPageList = explode(',', MS_TABLE_SELECTABLE_REC_PER_PAGE_LIST); ?>
<?php
foreach ($sRecPerPageList as $a) {
 $thisDisplayRecs = $a;
 if ($thisDisplayRecs > 0 ) {
   $thisValue = $thisDisplayRecs;  
?>
<option value="<?php echo $thisDisplayRecs; ?>"<?php if ($settings_list->DisplayRecs == $thisValue) { ?> selected="selected"<?php } ?>><?php echo $thisDisplayRecs; ?></option>
<?php	} else { ?>
<option value="ALL"<?php if ($settings->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
<?php
		}
	}
?>
</select>
</div>
<?php } ?>
<?php } ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($settings_list->Pager)) $settings_list->Pager = new cNumericPager($settings_list->StartRec, $settings_list->DisplayRecs, $settings_list->TotalRecs, $settings_list->RecRange) ?>
		<?php if ($settings_list->Pager->RecordCount > 0) { ?>
				<?php if (($settings_list->Pager->PageCount==1) && ($settings_list->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($settings_list->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_list->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($settings_list->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $settings_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($settings_list->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_list->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $settings_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $settings_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $settings_list->Pager->RecordCount ?></span>
				</div>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($settings_list->Pager)) $settings_list->Pager = new cPrevNextPager($settings_list->StartRec, $settings_list->DisplayRecs, $settings_list->TotalRecs) ?>
		<?php if ($settings_list->Pager->RecordCount > 0) { ?>
				<?php if (($settings_list->Pager->PageCount==1) && ($settings_list->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($settings_list->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($settings_list->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $settings_list->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($settings_list->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($settings_list->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_list->PageUrl() ?>start=<?php echo $settings_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $settings_list->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $settings_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $settings_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $settings_list->Pager->RecordCount ?></span>
				</div>
		<?php } ?>
	<?php } // end of link or button ?>	
<?php if ($settings_list->TotalRecs > 0) { ?>
<?php if ( (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right" && $Language->Phrase("dir")!="rtl") || (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right" && $Language->Phrase("dir")=="rtl") ) { ?>
<div class="ewPager"><span>&nbsp;<?php echo $Language->Phrase("RecordsPerPage") ?>&nbsp;</span>
<input type="hidden" name="t" value="settings">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="1"<?php if ($settings_list->DisplayRecs == 1) { ?> selected="selected"<?php } ?>>1</option>
<option value="3"<?php if ($settings_list->DisplayRecs == 3) { ?> selected="selected"<?php } ?>>3</option>
<option value="5"<?php if ($settings_list->DisplayRecs == 5) { ?> selected="selected"<?php } ?>>5</option>
<option value="10"<?php if ($settings_list->DisplayRecs == 10) { ?> selected="selected"<?php } ?>>10</option>
<option value="20"<?php if ($settings_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($settings_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($settings_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
</select>
</div>
<?php } // end if (MS_SELECTABLE_PAGE_SIZES_POSITION=="Right") ?>
<?php } // end TotalRecs ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($settings_list->OtherOptions as &$option)
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
<?php if ($settings_list->TotalRecs == 0 && $settings->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($settings_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php } // MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE is false ?>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">
fsettingslistsrch.Init();
fsettingslistsrch.FilterList = <?php echo $settings_list->GetFilterList() ?>;
fsettingslist.Init();
</script>
<?php } ?>
<?php
$settings_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_COLLAPSED) { ?>
<?php if (isset($_SESSION['table_settings_views']) && $_SESSION['table_settings_views'] == 1) { ?>
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
$(document).ready(function() { var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel'); if(getCookie('settings_searchpanel')=="active"){ SearchToggle.addClass(getCookie('settings_searchpanel')); SearchPanel.addClass('in'); SearchToggle.addClass('active'); }else{ SearchPanel.removeClass('in'); SearchToggle.removeClass('active'); } SearchToggle.on('click',function(event) { event.preventDefault(); if (SearchToggle.hasClass('active')){ createCookie("settings_searchpanel", "notactive", 1); }else{ createCookie("settings_searchpanel", "active", 1); } }); });
</script>
<?php } elseif (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_STATUS==TRUE && MS_USE_PHPMAKER_SETTING_FOR_INITIATE_SEARCH_PANEL==FALSE) { ?>
<script type="text/javascript">
$(document).ready(function() { var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel'); if(getCookie('settings_searchpanel')=="active"){ SearchToggle.addClass(getCookie('settings_searchpanel')); SearchPanel.addClass('in'); SearchToggle.addClass('active'); }else{ SearchPanel.removeClass('in'); SearchToggle.removeClass('active'); } SearchToggle.on('click',function(event) { event.preventDefault(); if (SearchToggle.hasClass('active')){ createCookie("settings_searchpanel", "notactive", 1); }else{ createCookie("settings_searchpanel", "active", 1); } }); });
</script>
<?php } ?>
<?php } ?>
<?php } else { // end of MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_COLLAPSED ?>
<?php if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_STATUS==TRUE && MS_USE_PHPMAKER_SETTING_FOR_INITIATE_SEARCH_PANEL==TRUE) { ?>
	<?php if (isset($_SESSION['table_settings_views']) && $_SESSION['table_settings_views'] == 1) { ?>
<script type="text/javascript">
$(document).ready(function() { var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel'); if(getCookie('settings_searchpanel')=="active"){ SearchToggle.addClass(getCookie('settings_searchpanel')); SearchPanel.addClass('in'); SearchToggle.addClass('active'); }else{ SearchPanel.removeClass('in'); SearchToggle.removeClass('active'); } SearchToggle.on('click',function(event) { event.preventDefault(); if (SearchToggle.hasClass('active')){ createCookie("settings_searchpanel", "notactive", 1); }else{ createCookie("settings_searchpanel", "active", 1); } }); });
</script>
	<?php } ?>
<?php } elseif (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_STATUS==TRUE && MS_USE_PHPMAKER_SETTING_FOR_INITIATE_SEARCH_PANEL==FALSE) { ?>
<script type="text/javascript">
$(document).ready(function() { var SearchToggle = $('.ewSearchToggle'); var SearchPanel = $('.ewSearchPanel'); if(getCookie('settings_searchpanel')=="active"){ SearchToggle.addClass(getCookie('settings_searchpanel')); SearchPanel.addClass('in'); SearchToggle.addClass('active'); }else{ SearchPanel.removeClass('in'); SearchToggle.removeClass('active'); } SearchToggle.on('click',function(event) { event.preventDefault(); if (SearchToggle.hasClass('active')){ createCookie("settings_searchpanel", "notactive", 1); }else{ createCookie("settings_searchpanel", "active", 1); } }); });
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
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">
$('.ewGridSave, .ewGridInsert').attr('onclick', 'return alertifySaveGrid(this)'); function alertifySaveGrid(obj) { <?php global $Language; ?> if (fsettingslist.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifySaveGridConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifySaveGrid'); ?>"); $("#fsettingslist").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<script type="text/javascript">
$('.ewInlineUpdate').attr('onclick', 'return alertifySaveInlineEdit(this)'); function alertifySaveInlineEdit(obj) { <?php global $Language; ?> if (fsettingslist.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifySaveGridConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifySaveGrid'); ?>"); $("#fsettingslist").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<script type="text/javascript">
$('.ewInlineInsert').attr('onclick', 'return alertifySaveInlineInsert(this)'); function alertifySaveInlineInsert(obj) { <?php global $Language; ?> if (fsettingslist.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifySaveGridConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifySaveGrid'); ?>"); $("#fsettingslist").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php if ($settings->CurrentAction == "" || $settings->Export == "") { // Change && become || in order to add scroll table in Grid, by Masino Sinaga, August 3, 2014 ?>
<script type="text/javascript">
<?php if (MS_TABLE_WIDTH_STYLE==1) { // Begin of modification Optimizing Main Table Width to Maximum Width of Site, by Masino Sinaga, April 30, 2012 ?>
<?php $iWidthAdjustment = (MS_MENU_HORIZONTAL) ? 0 : 100; ?>
ew_ScrollableTable("gmp_settings", "<?php echo (MS_SCROLL_TABLE_WIDTH - $iWidthAdjustment); ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_settings_empty_table", "<?php echo (MS_SCROLL_TABLE_WIDTH - $iWidthAdjustment); ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } elseif (MS_TABLE_WIDTH_STYLE==2) { ?>
ew_ScrollableTable("gmp_settings", "<?php echo MS_SCROLL_TABLE_WIDTH; ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_settings_empty_table", "<?php echo MS_SCROLL_TABLE_WIDTH; ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } elseif (MS_TABLE_WIDTH_STYLE==3) { ?>
ew_ScrollableTable("gmp_settings", "100%", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_settings_empty_table", "100%", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } // End of modification Optimizing Main Table Width to Maximum Width of Site, by Masino Sinaga, April 30, 2012 ?>
<?php } ?>
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$settings_list->Page_Terminate();
?>
