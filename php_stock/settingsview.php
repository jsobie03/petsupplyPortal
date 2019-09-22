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

$settings_view = NULL; // Initialize page object first

class csettings_view extends csettings {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'settings';

	// Page object name
	var $PageObjName = 'settings_view';

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
		$KeyUrl = "";
		if (@$_GET["Option_ID"] <> "") {
			$this->RecKey["Option_ID"] = $_GET["Option_ID"];
			$KeyUrl .= "&amp;Option_ID=" . urlencode($this->RecKey["Option_ID"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("settingslist.php"));
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
		if (@$_GET["Option_ID"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Option_ID"]);
		}

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

		// Setup export options
		$this->SetupExportOptions();
		$this->Option_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Set up multi page object
		$this->SetupMultiPages();

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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;
	var $MultiPages; // Multi pages object

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["Option_ID"] <> "") {
				$this->Option_ID->setQueryStringValue($_GET["Option_ID"]);
				$this->RecKey["Option_ID"] = $this->Option_ID->QueryStringValue;

			// Begin of changes v11.0.6
			} elseif (@$_POST["Option_ID"] <> "") {
				$this->Option_ID->setFormValue($_POST["Option_ID"]);
				$this->RecKey["Option_ID"] = $this->Option_ID->FormValue;

			// End of changes v11.0.6
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("settingslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->Option_ID->CurrentValue) == strval($this->Recordset->fields('Option_ID'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "settingslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			// Begin of modification Printer Friendly always does not use stylesheet, by Masino Sinaga, October 8, 2013 (added "print" in array)

			if ($this->CustomExport == "" && in_array($this->Export, array("html","print","word","excel","xml","csv","email","pdf"))) {

			// End of modification Printer Friendly always does not use stylesheet, by Masino Sinaga, October 8, 2013
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "settingslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

		// Font_Name
		if (strval($this->Font_Name->CurrentValue) <> "") {
			$this->Font_Name->ViewValue = $this->Font_Name->OptionCaption($this->Font_Name->CurrentValue);
		} else {
			$this->Font_Name->ViewValue = NULL;
		}
		$this->Font_Name->ViewCustomAttributes = "";

		// Font_Size
		if (strval($this->Font_Size->CurrentValue) <> "") {
			$this->Font_Size->ViewValue = $this->Font_Size->OptionCaption($this->Font_Size->CurrentValue);
		} else {
			$this->Font_Size->ViewValue = NULL;
		}
		$this->Font_Size->ViewCustomAttributes = "";

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

		// Vertical_Menu_Width
		$this->Vertical_Menu_Width->ViewValue = $this->Vertical_Menu_Width->CurrentValue;
		$this->Vertical_Menu_Width->ViewCustomAttributes = "";

		// Show_Announcement
		if (ew_ConvertToBool($this->Show_Announcement->CurrentValue)) {
			$this->Show_Announcement->ViewValue = $this->Show_Announcement->FldTagCaption(1) <> "" ? $this->Show_Announcement->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Announcement->ViewValue = $this->Show_Announcement->FldTagCaption(2) <> "" ? $this->Show_Announcement->FldTagCaption(2) : "No";
		}
		$this->Show_Announcement->ViewCustomAttributes = "";

		// Demo_Mode
		if (ew_ConvertToBool($this->Demo_Mode->CurrentValue)) {
			$this->Demo_Mode->ViewValue = $this->Demo_Mode->FldTagCaption(2) <> "" ? $this->Demo_Mode->FldTagCaption(2) : "Yes";
		} else {
			$this->Demo_Mode->ViewValue = $this->Demo_Mode->FldTagCaption(1) <> "" ? $this->Demo_Mode->FldTagCaption(1) : "No";
		}
		$this->Demo_Mode->ViewCustomAttributes = "";

		// Show_Page_Processing_Time
		if (ew_ConvertToBool($this->Show_Page_Processing_Time->CurrentValue)) {
			$this->Show_Page_Processing_Time->ViewValue = $this->Show_Page_Processing_Time->FldTagCaption(1) <> "" ? $this->Show_Page_Processing_Time->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Page_Processing_Time->ViewValue = $this->Show_Page_Processing_Time->FldTagCaption(2) <> "" ? $this->Show_Page_Processing_Time->FldTagCaption(2) : "No";
		}
		$this->Show_Page_Processing_Time->ViewCustomAttributes = "";

		// Allow_User_Preferences
		if (ew_ConvertToBool($this->Allow_User_Preferences->CurrentValue)) {
			$this->Allow_User_Preferences->ViewValue = $this->Allow_User_Preferences->FldTagCaption(2) <> "" ? $this->Allow_User_Preferences->FldTagCaption(2) : "Yes";
		} else {
			$this->Allow_User_Preferences->ViewValue = $this->Allow_User_Preferences->FldTagCaption(1) <> "" ? $this->Allow_User_Preferences->FldTagCaption(1) : "No";
		}
		$this->Allow_User_Preferences->ViewCustomAttributes = "";

		// SMTP_Server
		$this->SMTP_Server->ViewValue = $this->SMTP_Server->CurrentValue;
		$this->SMTP_Server->ViewCustomAttributes = "";

		// SMTP_Server_Port
		$this->SMTP_Server_Port->ViewValue = $this->SMTP_Server_Port->CurrentValue;
		$this->SMTP_Server_Port->ViewCustomAttributes = "";

		// SMTP_Server_Username
		$this->SMTP_Server_Username->ViewValue = $this->SMTP_Server_Username->CurrentValue;
		$this->SMTP_Server_Username->ViewCustomAttributes = "";

		// SMTP_Server_Password
		$this->SMTP_Server_Password->ViewValue = $this->SMTP_Server_Password->CurrentValue;
		$this->SMTP_Server_Password->ViewCustomAttributes = "";

		// Sender_Email
		$this->Sender_Email->ViewValue = $this->Sender_Email->CurrentValue;
		$this->Sender_Email->ViewCustomAttributes = "";

		// Recipient_Email
		$this->Recipient_Email->ViewValue = $this->Recipient_Email->CurrentValue;
		$this->Recipient_Email->ViewCustomAttributes = "";

		// Use_Default_Locale
		if (ew_ConvertToBool($this->Use_Default_Locale->CurrentValue)) {
			$this->Use_Default_Locale->ViewValue = $this->Use_Default_Locale->FldTagCaption(1) <> "" ? $this->Use_Default_Locale->FldTagCaption(1) : "Yes";
		} else {
			$this->Use_Default_Locale->ViewValue = $this->Use_Default_Locale->FldTagCaption(2) <> "" ? $this->Use_Default_Locale->FldTagCaption(2) : "No";
		}
		$this->Use_Default_Locale->ViewCustomAttributes = "";

		// Default_Language
		if (strval($this->Default_Language->CurrentValue) <> "") {
			$sFilterWrk = "`Language_Code`" . ew_SearchString("=", $this->Default_Language->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Language_Code`, `Language_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `languages`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Language_Code`, `Language_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `languages`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Default_Language, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Default_Language->ViewValue = $this->Default_Language->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Default_Language->ViewValue = $this->Default_Language->CurrentValue;
			}
		} else {
			$this->Default_Language->ViewValue = NULL;
		}
		$this->Default_Language->ViewCustomAttributes = "";

		// Default_Timezone
		if (strval($this->Default_Timezone->CurrentValue) <> "") {
			$sFilterWrk = "`Timezone`" . ew_SearchString("=", $this->Default_Timezone->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Timezone`, `Timezone` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `timezone`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Timezone`, `Timezone` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `timezone`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Default_Timezone, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Default_Timezone->ViewValue = $this->Default_Timezone->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Default_Timezone->ViewValue = $this->Default_Timezone->CurrentValue;
			}
		} else {
			$this->Default_Timezone->ViewValue = NULL;
		}
		$this->Default_Timezone->ViewCustomAttributes = "";

		// Default_Thousands_Separator
		$this->Default_Thousands_Separator->ViewValue = $this->Default_Thousands_Separator->CurrentValue;
		$this->Default_Thousands_Separator->ViewCustomAttributes = "";

		// Default_Decimal_Point
		$this->Default_Decimal_Point->ViewValue = $this->Default_Decimal_Point->CurrentValue;
		$this->Default_Decimal_Point->ViewCustomAttributes = "";

		// Default_Currency_Symbol
		$this->Default_Currency_Symbol->ViewValue = $this->Default_Currency_Symbol->CurrentValue;
		$this->Default_Currency_Symbol->ViewCustomAttributes = "";

		// Default_Money_Thousands_Separator
		$this->Default_Money_Thousands_Separator->ViewValue = $this->Default_Money_Thousands_Separator->CurrentValue;
		$this->Default_Money_Thousands_Separator->ViewCustomAttributes = "";

		// Default_Money_Decimal_Point
		$this->Default_Money_Decimal_Point->ViewValue = $this->Default_Money_Decimal_Point->CurrentValue;
		$this->Default_Money_Decimal_Point->ViewCustomAttributes = "";

		// Maintenance_Mode
		if (ew_ConvertToBool($this->Maintenance_Mode->CurrentValue)) {
			$this->Maintenance_Mode->ViewValue = $this->Maintenance_Mode->FldTagCaption(2) <> "" ? $this->Maintenance_Mode->FldTagCaption(2) : "Yes";
		} else {
			$this->Maintenance_Mode->ViewValue = $this->Maintenance_Mode->FldTagCaption(1) <> "" ? $this->Maintenance_Mode->FldTagCaption(1) : "No";
		}
		$this->Maintenance_Mode->ViewCustomAttributes = "";

		// Maintenance_Finish_DateTime
		$this->Maintenance_Finish_DateTime->ViewValue = $this->Maintenance_Finish_DateTime->CurrentValue;
		$this->Maintenance_Finish_DateTime->ViewValue = ew_FormatDateTime($this->Maintenance_Finish_DateTime->ViewValue, 9);
		$this->Maintenance_Finish_DateTime->ViewCustomAttributes = "";

		// Auto_Normal_After_Maintenance
		if (ew_ConvertToBool($this->Auto_Normal_After_Maintenance->CurrentValue)) {
			$this->Auto_Normal_After_Maintenance->ViewValue = $this->Auto_Normal_After_Maintenance->FldTagCaption(1) <> "" ? $this->Auto_Normal_After_Maintenance->FldTagCaption(1) : "Yes";
		} else {
			$this->Auto_Normal_After_Maintenance->ViewValue = $this->Auto_Normal_After_Maintenance->FldTagCaption(2) <> "" ? $this->Auto_Normal_After_Maintenance->FldTagCaption(2) : "No";
		}
		$this->Auto_Normal_After_Maintenance->ViewCustomAttributes = "";

		// Allow_User_To_Register
		if (ew_ConvertToBool($this->Allow_User_To_Register->CurrentValue)) {
			$this->Allow_User_To_Register->ViewValue = $this->Allow_User_To_Register->FldTagCaption(1) <> "" ? $this->Allow_User_To_Register->FldTagCaption(1) : "Yes";
		} else {
			$this->Allow_User_To_Register->ViewValue = $this->Allow_User_To_Register->FldTagCaption(2) <> "" ? $this->Allow_User_To_Register->FldTagCaption(2) : "No";
		}
		$this->Allow_User_To_Register->ViewCustomAttributes = "";

		// Suspend_New_User_Account
		if (ew_ConvertToBool($this->Suspend_New_User_Account->CurrentValue)) {
			$this->Suspend_New_User_Account->ViewValue = $this->Suspend_New_User_Account->FldTagCaption(2) <> "" ? $this->Suspend_New_User_Account->FldTagCaption(2) : "Yes";
		} else {
			$this->Suspend_New_User_Account->ViewValue = $this->Suspend_New_User_Account->FldTagCaption(1) <> "" ? $this->Suspend_New_User_Account->FldTagCaption(1) : "No";
		}
		$this->Suspend_New_User_Account->ViewCustomAttributes = "";

		// User_Need_Activation_After_Registered
		if (ew_ConvertToBool($this->User_Need_Activation_After_Registered->CurrentValue)) {
			$this->User_Need_Activation_After_Registered->ViewValue = $this->User_Need_Activation_After_Registered->FldTagCaption(1) <> "" ? $this->User_Need_Activation_After_Registered->FldTagCaption(1) : "Yes";
		} else {
			$this->User_Need_Activation_After_Registered->ViewValue = $this->User_Need_Activation_After_Registered->FldTagCaption(2) <> "" ? $this->User_Need_Activation_After_Registered->FldTagCaption(2) : "No";
		}
		$this->User_Need_Activation_After_Registered->ViewCustomAttributes = "";

		// Show_Captcha_On_Registration_Page
		if (ew_ConvertToBool($this->Show_Captcha_On_Registration_Page->CurrentValue)) {
			$this->Show_Captcha_On_Registration_Page->ViewValue = $this->Show_Captcha_On_Registration_Page->FldTagCaption(1) <> "" ? $this->Show_Captcha_On_Registration_Page->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Captcha_On_Registration_Page->ViewValue = $this->Show_Captcha_On_Registration_Page->FldTagCaption(2) <> "" ? $this->Show_Captcha_On_Registration_Page->FldTagCaption(2) : "No";
		}
		$this->Show_Captcha_On_Registration_Page->ViewCustomAttributes = "";

		// Show_Terms_And_Conditions_On_Registration_Page
		if (ew_ConvertToBool($this->Show_Terms_And_Conditions_On_Registration_Page->CurrentValue)) {
			$this->Show_Terms_And_Conditions_On_Registration_Page->ViewValue = $this->Show_Terms_And_Conditions_On_Registration_Page->FldTagCaption(1) <> "" ? $this->Show_Terms_And_Conditions_On_Registration_Page->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Terms_And_Conditions_On_Registration_Page->ViewValue = $this->Show_Terms_And_Conditions_On_Registration_Page->FldTagCaption(2) <> "" ? $this->Show_Terms_And_Conditions_On_Registration_Page->FldTagCaption(2) : "No";
		}
		$this->Show_Terms_And_Conditions_On_Registration_Page->ViewCustomAttributes = "";

		// User_Auto_Login_After_Activation_Or_Registration
		if (ew_ConvertToBool($this->User_Auto_Login_After_Activation_Or_Registration->CurrentValue)) {
			$this->User_Auto_Login_After_Activation_Or_Registration->ViewValue = $this->User_Auto_Login_After_Activation_Or_Registration->FldTagCaption(1) <> "" ? $this->User_Auto_Login_After_Activation_Or_Registration->FldTagCaption(1) : "Yes";
		} else {
			$this->User_Auto_Login_After_Activation_Or_Registration->ViewValue = $this->User_Auto_Login_After_Activation_Or_Registration->FldTagCaption(2) <> "" ? $this->User_Auto_Login_After_Activation_Or_Registration->FldTagCaption(2) : "No";
		}
		$this->User_Auto_Login_After_Activation_Or_Registration->ViewCustomAttributes = "";

		// Show_Captcha_On_Login_Page
		if (ew_ConvertToBool($this->Show_Captcha_On_Login_Page->CurrentValue)) {
			$this->Show_Captcha_On_Login_Page->ViewValue = $this->Show_Captcha_On_Login_Page->FldTagCaption(2) <> "" ? $this->Show_Captcha_On_Login_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Captcha_On_Login_Page->ViewValue = $this->Show_Captcha_On_Login_Page->FldTagCaption(1) <> "" ? $this->Show_Captcha_On_Login_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Captcha_On_Login_Page->ViewCustomAttributes = "";

		// Show_Captcha_On_Forgot_Password_Page
		if (ew_ConvertToBool($this->Show_Captcha_On_Forgot_Password_Page->CurrentValue)) {
			$this->Show_Captcha_On_Forgot_Password_Page->ViewValue = $this->Show_Captcha_On_Forgot_Password_Page->FldTagCaption(2) <> "" ? $this->Show_Captcha_On_Forgot_Password_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Captcha_On_Forgot_Password_Page->ViewValue = $this->Show_Captcha_On_Forgot_Password_Page->FldTagCaption(1) <> "" ? $this->Show_Captcha_On_Forgot_Password_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Captcha_On_Forgot_Password_Page->ViewCustomAttributes = "";

		// Show_Captcha_On_Change_Password_Page
		if (ew_ConvertToBool($this->Show_Captcha_On_Change_Password_Page->CurrentValue)) {
			$this->Show_Captcha_On_Change_Password_Page->ViewValue = $this->Show_Captcha_On_Change_Password_Page->FldTagCaption(2) <> "" ? $this->Show_Captcha_On_Change_Password_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Captcha_On_Change_Password_Page->ViewValue = $this->Show_Captcha_On_Change_Password_Page->FldTagCaption(1) <> "" ? $this->Show_Captcha_On_Change_Password_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Captcha_On_Change_Password_Page->ViewCustomAttributes = "";

		// User_Auto_Logout_After_Idle_In_Minutes
		$this->User_Auto_Logout_After_Idle_In_Minutes->ViewValue = $this->User_Auto_Logout_After_Idle_In_Minutes->CurrentValue;
		$this->User_Auto_Logout_After_Idle_In_Minutes->ViewCustomAttributes = "";

		// User_Login_Maximum_Retry
		$this->User_Login_Maximum_Retry->ViewValue = $this->User_Login_Maximum_Retry->CurrentValue;
		$this->User_Login_Maximum_Retry->ViewCustomAttributes = "";

		// User_Login_Retry_Lockout
		$this->User_Login_Retry_Lockout->ViewValue = $this->User_Login_Retry_Lockout->CurrentValue;
		$this->User_Login_Retry_Lockout->ViewCustomAttributes = "";

		// Redirect_To_Last_Visited_Page_After_Login
		if (ew_ConvertToBool($this->Redirect_To_Last_Visited_Page_After_Login->CurrentValue)) {
			$this->Redirect_To_Last_Visited_Page_After_Login->ViewValue = $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(1) <> "" ? $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(1) : "Yes";
		} else {
			$this->Redirect_To_Last_Visited_Page_After_Login->ViewValue = $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(2) <> "" ? $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(2) : "No";
		}
		$this->Redirect_To_Last_Visited_Page_After_Login->ViewCustomAttributes = "";

		// Enable_Password_Expiry
		if (ew_ConvertToBool($this->Enable_Password_Expiry->CurrentValue)) {
			$this->Enable_Password_Expiry->ViewValue = $this->Enable_Password_Expiry->FldTagCaption(1) <> "" ? $this->Enable_Password_Expiry->FldTagCaption(1) : "Yes";
		} else {
			$this->Enable_Password_Expiry->ViewValue = $this->Enable_Password_Expiry->FldTagCaption(2) <> "" ? $this->Enable_Password_Expiry->FldTagCaption(2) : "No";
		}
		$this->Enable_Password_Expiry->ViewCustomAttributes = "";

		// Password_Expiry_In_Days
		$this->Password_Expiry_In_Days->ViewValue = $this->Password_Expiry_In_Days->CurrentValue;
		$this->Password_Expiry_In_Days->ViewCustomAttributes = "";

		// Show_Entire_Header
		if (ew_ConvertToBool($this->Show_Entire_Header->CurrentValue)) {
			$this->Show_Entire_Header->ViewValue = $this->Show_Entire_Header->FldTagCaption(1) <> "" ? $this->Show_Entire_Header->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Entire_Header->ViewValue = $this->Show_Entire_Header->FldTagCaption(2) <> "" ? $this->Show_Entire_Header->FldTagCaption(2) : "No";
		}
		$this->Show_Entire_Header->ViewCustomAttributes = "";

		// Logo_Width
		$this->Logo_Width->ViewValue = $this->Logo_Width->CurrentValue;
		$this->Logo_Width->ViewCustomAttributes = "";

		// Show_Site_Title_In_Header
		if (ew_ConvertToBool($this->Show_Site_Title_In_Header->CurrentValue)) {
			$this->Show_Site_Title_In_Header->ViewValue = $this->Show_Site_Title_In_Header->FldTagCaption(1) <> "" ? $this->Show_Site_Title_In_Header->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Site_Title_In_Header->ViewValue = $this->Show_Site_Title_In_Header->FldTagCaption(2) <> "" ? $this->Show_Site_Title_In_Header->FldTagCaption(2) : "No";
		}
		$this->Show_Site_Title_In_Header->ViewCustomAttributes = "";

		// Show_Current_User_In_Header
		if (ew_ConvertToBool($this->Show_Current_User_In_Header->CurrentValue)) {
			$this->Show_Current_User_In_Header->ViewValue = $this->Show_Current_User_In_Header->FldTagCaption(1) <> "" ? $this->Show_Current_User_In_Header->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Current_User_In_Header->ViewValue = $this->Show_Current_User_In_Header->FldTagCaption(2) <> "" ? $this->Show_Current_User_In_Header->FldTagCaption(2) : "No";
		}
		$this->Show_Current_User_In_Header->ViewCustomAttributes = "";

		// Text_Align_In_Header
		if (strval($this->Text_Align_In_Header->CurrentValue) <> "") {
			$this->Text_Align_In_Header->ViewValue = $this->Text_Align_In_Header->OptionCaption($this->Text_Align_In_Header->CurrentValue);
		} else {
			$this->Text_Align_In_Header->ViewValue = NULL;
		}
		$this->Text_Align_In_Header->ViewCustomAttributes = "";

		// Site_Title_Text_Style
		if (strval($this->Site_Title_Text_Style->CurrentValue) <> "") {
			$this->Site_Title_Text_Style->ViewValue = $this->Site_Title_Text_Style->OptionCaption($this->Site_Title_Text_Style->CurrentValue);
		} else {
			$this->Site_Title_Text_Style->ViewValue = NULL;
		}
		$this->Site_Title_Text_Style->ViewCustomAttributes = "";

		// Language_Selector_Visibility
		if (strval($this->Language_Selector_Visibility->CurrentValue) <> "") {
			$this->Language_Selector_Visibility->ViewValue = $this->Language_Selector_Visibility->OptionCaption($this->Language_Selector_Visibility->CurrentValue);
		} else {
			$this->Language_Selector_Visibility->ViewValue = NULL;
		}
		$this->Language_Selector_Visibility->ViewCustomAttributes = "";

		// Language_Selector_Align
		if (strval($this->Language_Selector_Align->CurrentValue) <> "") {
			$this->Language_Selector_Align->ViewValue = $this->Language_Selector_Align->OptionCaption($this->Language_Selector_Align->CurrentValue);
		} else {
			$this->Language_Selector_Align->ViewValue = NULL;
		}
		$this->Language_Selector_Align->ViewCustomAttributes = "";

		// Show_Entire_Footer
		if (ew_ConvertToBool($this->Show_Entire_Footer->CurrentValue)) {
			$this->Show_Entire_Footer->ViewValue = $this->Show_Entire_Footer->FldTagCaption(1) <> "" ? $this->Show_Entire_Footer->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Entire_Footer->ViewValue = $this->Show_Entire_Footer->FldTagCaption(2) <> "" ? $this->Show_Entire_Footer->FldTagCaption(2) : "No";
		}
		$this->Show_Entire_Footer->ViewCustomAttributes = "";

		// Show_Text_In_Footer
		if (ew_ConvertToBool($this->Show_Text_In_Footer->CurrentValue)) {
			$this->Show_Text_In_Footer->ViewValue = $this->Show_Text_In_Footer->FldTagCaption(1) <> "" ? $this->Show_Text_In_Footer->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Text_In_Footer->ViewValue = $this->Show_Text_In_Footer->FldTagCaption(2) <> "" ? $this->Show_Text_In_Footer->FldTagCaption(2) : "No";
		}
		$this->Show_Text_In_Footer->ViewCustomAttributes = "";

		// Show_Back_To_Top_On_Footer
		if (ew_ConvertToBool($this->Show_Back_To_Top_On_Footer->CurrentValue)) {
			$this->Show_Back_To_Top_On_Footer->ViewValue = $this->Show_Back_To_Top_On_Footer->FldTagCaption(2) <> "" ? $this->Show_Back_To_Top_On_Footer->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Back_To_Top_On_Footer->ViewValue = $this->Show_Back_To_Top_On_Footer->FldTagCaption(1) <> "" ? $this->Show_Back_To_Top_On_Footer->FldTagCaption(1) : "No";
		}
		$this->Show_Back_To_Top_On_Footer->ViewCustomAttributes = "";

		// Show_Terms_And_Conditions_On_Footer
		if (ew_ConvertToBool($this->Show_Terms_And_Conditions_On_Footer->CurrentValue)) {
			$this->Show_Terms_And_Conditions_On_Footer->ViewValue = $this->Show_Terms_And_Conditions_On_Footer->FldTagCaption(1) <> "" ? $this->Show_Terms_And_Conditions_On_Footer->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Terms_And_Conditions_On_Footer->ViewValue = $this->Show_Terms_And_Conditions_On_Footer->FldTagCaption(2) <> "" ? $this->Show_Terms_And_Conditions_On_Footer->FldTagCaption(2) : "No";
		}
		$this->Show_Terms_And_Conditions_On_Footer->ViewCustomAttributes = "";

		// Show_About_Us_On_Footer
		if (ew_ConvertToBool($this->Show_About_Us_On_Footer->CurrentValue)) {
			$this->Show_About_Us_On_Footer->ViewValue = $this->Show_About_Us_On_Footer->FldTagCaption(2) <> "" ? $this->Show_About_Us_On_Footer->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_About_Us_On_Footer->ViewValue = $this->Show_About_Us_On_Footer->FldTagCaption(1) <> "" ? $this->Show_About_Us_On_Footer->FldTagCaption(1) : "No";
		}
		$this->Show_About_Us_On_Footer->ViewCustomAttributes = "";

		// Pagination_Position
		if (strval($this->Pagination_Position->CurrentValue) <> "") {
			$this->Pagination_Position->ViewValue = $this->Pagination_Position->OptionCaption($this->Pagination_Position->CurrentValue);
		} else {
			$this->Pagination_Position->ViewValue = NULL;
		}
		$this->Pagination_Position->ViewCustomAttributes = "";

		// Pagination_Style
		if (strval($this->Pagination_Style->CurrentValue) <> "") {
			$this->Pagination_Style->ViewValue = $this->Pagination_Style->OptionCaption($this->Pagination_Style->CurrentValue);
		} else {
			$this->Pagination_Style->ViewValue = NULL;
		}
		$this->Pagination_Style->ViewCustomAttributes = "";

		// Selectable_Records_Per_Page
		$this->Selectable_Records_Per_Page->ViewValue = $this->Selectable_Records_Per_Page->CurrentValue;
		$this->Selectable_Records_Per_Page->ViewCustomAttributes = "";

		// Selectable_Groups_Per_Page
		$this->Selectable_Groups_Per_Page->ViewValue = $this->Selectable_Groups_Per_Page->CurrentValue;
		$this->Selectable_Groups_Per_Page->ViewCustomAttributes = "";

		// Default_Record_Per_Page
		$this->Default_Record_Per_Page->ViewValue = $this->Default_Record_Per_Page->CurrentValue;
		$this->Default_Record_Per_Page->ViewCustomAttributes = "";

		// Default_Group_Per_Page
		$this->Default_Group_Per_Page->ViewValue = $this->Default_Group_Per_Page->CurrentValue;
		$this->Default_Group_Per_Page->ViewCustomAttributes = "";

		// Maximum_Selected_Records
		$this->Maximum_Selected_Records->ViewValue = $this->Maximum_Selected_Records->CurrentValue;
		$this->Maximum_Selected_Records->ViewCustomAttributes = "";

		// Maximum_Selected_Groups
		$this->Maximum_Selected_Groups->ViewValue = $this->Maximum_Selected_Groups->CurrentValue;
		$this->Maximum_Selected_Groups->ViewCustomAttributes = "";

		// Show_PageNum_If_Record_Not_Over_Pagesize
		if (ew_ConvertToBool($this->Show_PageNum_If_Record_Not_Over_Pagesize->CurrentValue)) {
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->ViewValue = $this->Show_PageNum_If_Record_Not_Over_Pagesize->FldTagCaption(1) <> "" ? $this->Show_PageNum_If_Record_Not_Over_Pagesize->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->ViewValue = $this->Show_PageNum_If_Record_Not_Over_Pagesize->FldTagCaption(2) <> "" ? $this->Show_PageNum_If_Record_Not_Over_Pagesize->FldTagCaption(2) : "No";
		}
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->ViewCustomAttributes = "";

		// Table_Width_Style
		if (strval($this->Table_Width_Style->CurrentValue) <> "") {
			$this->Table_Width_Style->ViewValue = $this->Table_Width_Style->OptionCaption($this->Table_Width_Style->CurrentValue);
		} else {
			$this->Table_Width_Style->ViewValue = NULL;
		}
		$this->Table_Width_Style->ViewCustomAttributes = "";

		// Scroll_Table_Width
		$this->Scroll_Table_Width->ViewValue = $this->Scroll_Table_Width->CurrentValue;
		$this->Scroll_Table_Width->ViewCustomAttributes = "";

		// Scroll_Table_Height
		$this->Scroll_Table_Height->ViewValue = $this->Scroll_Table_Height->CurrentValue;
		$this->Scroll_Table_Height->ViewCustomAttributes = "";

		// Search_Panel_Collapsed
		if (ew_ConvertToBool($this->Search_Panel_Collapsed->CurrentValue)) {
			$this->Search_Panel_Collapsed->ViewValue = $this->Search_Panel_Collapsed->FldTagCaption(1) <> "" ? $this->Search_Panel_Collapsed->FldTagCaption(1) : "Yes";
		} else {
			$this->Search_Panel_Collapsed->ViewValue = $this->Search_Panel_Collapsed->FldTagCaption(2) <> "" ? $this->Search_Panel_Collapsed->FldTagCaption(2) : "No";
		}
		$this->Search_Panel_Collapsed->ViewCustomAttributes = "";

		// Filter_Panel_Collapsed
		if (ew_ConvertToBool($this->Filter_Panel_Collapsed->CurrentValue)) {
			$this->Filter_Panel_Collapsed->ViewValue = $this->Filter_Panel_Collapsed->FldTagCaption(1) <> "" ? $this->Filter_Panel_Collapsed->FldTagCaption(1) : "Yes";
		} else {
			$this->Filter_Panel_Collapsed->ViewValue = $this->Filter_Panel_Collapsed->FldTagCaption(2) <> "" ? $this->Filter_Panel_Collapsed->FldTagCaption(2) : "No";
		}
		$this->Filter_Panel_Collapsed->ViewCustomAttributes = "";

		// Show_Record_Number_On_List_Page
		if (ew_ConvertToBool($this->Show_Record_Number_On_List_Page->CurrentValue)) {
			$this->Show_Record_Number_On_List_Page->ViewValue = $this->Show_Record_Number_On_List_Page->FldTagCaption(2) <> "" ? $this->Show_Record_Number_On_List_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Record_Number_On_List_Page->ViewValue = $this->Show_Record_Number_On_List_Page->FldTagCaption(1) <> "" ? $this->Show_Record_Number_On_List_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Record_Number_On_List_Page->ViewCustomAttributes = "";

		// Show_Empty_Table_On_List_Page
		if (ew_ConvertToBool($this->Show_Empty_Table_On_List_Page->CurrentValue)) {
			$this->Show_Empty_Table_On_List_Page->ViewValue = $this->Show_Empty_Table_On_List_Page->FldTagCaption(2) <> "" ? $this->Show_Empty_Table_On_List_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Empty_Table_On_List_Page->ViewValue = $this->Show_Empty_Table_On_List_Page->FldTagCaption(1) <> "" ? $this->Show_Empty_Table_On_List_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Empty_Table_On_List_Page->ViewCustomAttributes = "";

		// Rows_Vertical_Align_Top
		if (ew_ConvertToBool($this->Rows_Vertical_Align_Top->CurrentValue)) {
			$this->Rows_Vertical_Align_Top->ViewValue = $this->Rows_Vertical_Align_Top->FldTagCaption(2) <> "" ? $this->Rows_Vertical_Align_Top->FldTagCaption(2) : "Yes";
		} else {
			$this->Rows_Vertical_Align_Top->ViewValue = $this->Rows_Vertical_Align_Top->FldTagCaption(1) <> "" ? $this->Rows_Vertical_Align_Top->FldTagCaption(1) : "No";
		}
		$this->Rows_Vertical_Align_Top->ViewCustomAttributes = "";

		// Action_Button_Alignment
		if (strval($this->Action_Button_Alignment->CurrentValue) <> "") {
			$this->Action_Button_Alignment->ViewValue = $this->Action_Button_Alignment->OptionCaption($this->Action_Button_Alignment->CurrentValue);
		} else {
			$this->Action_Button_Alignment->ViewValue = NULL;
		}
		$this->Action_Button_Alignment->ViewCustomAttributes = "";

		// Show_Add_Success_Message
		if (ew_ConvertToBool($this->Show_Add_Success_Message->CurrentValue)) {
			$this->Show_Add_Success_Message->ViewValue = $this->Show_Add_Success_Message->FldTagCaption(2) <> "" ? $this->Show_Add_Success_Message->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Add_Success_Message->ViewValue = $this->Show_Add_Success_Message->FldTagCaption(1) <> "" ? $this->Show_Add_Success_Message->FldTagCaption(1) : "No";
		}
		$this->Show_Add_Success_Message->ViewCustomAttributes = "";

		// Show_Edit_Success_Message
		if (ew_ConvertToBool($this->Show_Edit_Success_Message->CurrentValue)) {
			$this->Show_Edit_Success_Message->ViewValue = $this->Show_Edit_Success_Message->FldTagCaption(2) <> "" ? $this->Show_Edit_Success_Message->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Edit_Success_Message->ViewValue = $this->Show_Edit_Success_Message->FldTagCaption(1) <> "" ? $this->Show_Edit_Success_Message->FldTagCaption(1) : "No";
		}
		$this->Show_Edit_Success_Message->ViewCustomAttributes = "";

		// jQuery_Auto_Hide_Success_Message
		if (ew_ConvertToBool($this->jQuery_Auto_Hide_Success_Message->CurrentValue)) {
			$this->jQuery_Auto_Hide_Success_Message->ViewValue = $this->jQuery_Auto_Hide_Success_Message->FldTagCaption(2) <> "" ? $this->jQuery_Auto_Hide_Success_Message->FldTagCaption(2) : "Yes";
		} else {
			$this->jQuery_Auto_Hide_Success_Message->ViewValue = $this->jQuery_Auto_Hide_Success_Message->FldTagCaption(1) <> "" ? $this->jQuery_Auto_Hide_Success_Message->FldTagCaption(1) : "No";
		}
		$this->jQuery_Auto_Hide_Success_Message->ViewCustomAttributes = "";

		// Use_Javascript_Message
		if (ew_ConvertToBool($this->Use_Javascript_Message->CurrentValue)) {
			$this->Use_Javascript_Message->ViewValue = $this->Use_Javascript_Message->FldTagCaption(1) <> "" ? $this->Use_Javascript_Message->FldTagCaption(1) : "Yes";
		} else {
			$this->Use_Javascript_Message->ViewValue = $this->Use_Javascript_Message->FldTagCaption(2) <> "" ? $this->Use_Javascript_Message->FldTagCaption(2) : "No";
		}
		$this->Use_Javascript_Message->ViewCustomAttributes = "";

		// Login_Window_Type
		if (strval($this->Login_Window_Type->CurrentValue) <> "") {
			$this->Login_Window_Type->ViewValue = $this->Login_Window_Type->OptionCaption($this->Login_Window_Type->CurrentValue);
		} else {
			$this->Login_Window_Type->ViewValue = NULL;
		}
		$this->Login_Window_Type->ViewCustomAttributes = "";

		// Forgot_Password_Window_Type
		if (strval($this->Forgot_Password_Window_Type->CurrentValue) <> "") {
			$this->Forgot_Password_Window_Type->ViewValue = $this->Forgot_Password_Window_Type->OptionCaption($this->Forgot_Password_Window_Type->CurrentValue);
		} else {
			$this->Forgot_Password_Window_Type->ViewValue = NULL;
		}
		$this->Forgot_Password_Window_Type->ViewCustomAttributes = "";

		// Change_Password_Window_Type
		if (strval($this->Change_Password_Window_Type->CurrentValue) <> "") {
			$this->Change_Password_Window_Type->ViewValue = $this->Change_Password_Window_Type->OptionCaption($this->Change_Password_Window_Type->CurrentValue);
		} else {
			$this->Change_Password_Window_Type->ViewValue = NULL;
		}
		$this->Change_Password_Window_Type->ViewCustomAttributes = "";

		// Registration_Window_Type
		if (strval($this->Registration_Window_Type->CurrentValue) <> "") {
			$this->Registration_Window_Type->ViewValue = $this->Registration_Window_Type->OptionCaption($this->Registration_Window_Type->CurrentValue);
		} else {
			$this->Registration_Window_Type->ViewValue = NULL;
		}
		$this->Registration_Window_Type->ViewCustomAttributes = "";

		// Show_Record_Number_On_Detail_Preview
		if (ew_ConvertToBool($this->Show_Record_Number_On_Detail_Preview->CurrentValue)) {
			$this->Show_Record_Number_On_Detail_Preview->ViewValue = $this->Show_Record_Number_On_Detail_Preview->FldTagCaption(2) <> "" ? $this->Show_Record_Number_On_Detail_Preview->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Record_Number_On_Detail_Preview->ViewValue = $this->Show_Record_Number_On_Detail_Preview->FldTagCaption(1) <> "" ? $this->Show_Record_Number_On_Detail_Preview->FldTagCaption(1) : "No";
		}
		$this->Show_Record_Number_On_Detail_Preview->ViewCustomAttributes = "";

		// Show_Empty_Table_In_Detail_Preview
		if (ew_ConvertToBool($this->Show_Empty_Table_In_Detail_Preview->CurrentValue)) {
			$this->Show_Empty_Table_In_Detail_Preview->ViewValue = $this->Show_Empty_Table_In_Detail_Preview->FldTagCaption(2) <> "" ? $this->Show_Empty_Table_In_Detail_Preview->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Empty_Table_In_Detail_Preview->ViewValue = $this->Show_Empty_Table_In_Detail_Preview->FldTagCaption(1) <> "" ? $this->Show_Empty_Table_In_Detail_Preview->FldTagCaption(1) : "No";
		}
		$this->Show_Empty_Table_In_Detail_Preview->ViewCustomAttributes = "";

		// Detail_Preview_Table_Width
		$this->Detail_Preview_Table_Width->ViewValue = $this->Detail_Preview_Table_Width->CurrentValue;
		$this->Detail_Preview_Table_Width->ViewCustomAttributes = "";

		// Password_Minimum_Length
		$this->Password_Minimum_Length->ViewValue = $this->Password_Minimum_Length->CurrentValue;
		$this->Password_Minimum_Length->ViewCustomAttributes = "";

		// Password_Maximum_Length
		$this->Password_Maximum_Length->ViewValue = $this->Password_Maximum_Length->CurrentValue;
		$this->Password_Maximum_Length->ViewCustomAttributes = "";

		// Password_Must_Contain_At_Least_One_Lower_Case
		if (ew_ConvertToBool($this->Password_Must_Contain_At_Least_One_Lower_Case->CurrentValue)) {
			$this->Password_Must_Contain_At_Least_One_Lower_Case->ViewValue = $this->Password_Must_Contain_At_Least_One_Lower_Case->FldTagCaption(2) <> "" ? $this->Password_Must_Contain_At_Least_One_Lower_Case->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Contain_At_Least_One_Lower_Case->ViewValue = $this->Password_Must_Contain_At_Least_One_Lower_Case->FldTagCaption(1) <> "" ? $this->Password_Must_Contain_At_Least_One_Lower_Case->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Contain_At_Least_One_Lower_Case->ViewCustomAttributes = "";

		// Password_Must_Comply_With_Minumum_Length
		if (ew_ConvertToBool($this->Password_Must_Comply_With_Minumum_Length->CurrentValue)) {
			$this->Password_Must_Comply_With_Minumum_Length->ViewValue = $this->Password_Must_Comply_With_Minumum_Length->FldTagCaption(2) <> "" ? $this->Password_Must_Comply_With_Minumum_Length->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Comply_With_Minumum_Length->ViewValue = $this->Password_Must_Comply_With_Minumum_Length->FldTagCaption(1) <> "" ? $this->Password_Must_Comply_With_Minumum_Length->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Comply_With_Minumum_Length->ViewCustomAttributes = "";

		// Password_Must_Comply_With_Maximum_Length
		if (ew_ConvertToBool($this->Password_Must_Comply_With_Maximum_Length->CurrentValue)) {
			$this->Password_Must_Comply_With_Maximum_Length->ViewValue = $this->Password_Must_Comply_With_Maximum_Length->FldTagCaption(2) <> "" ? $this->Password_Must_Comply_With_Maximum_Length->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Comply_With_Maximum_Length->ViewValue = $this->Password_Must_Comply_With_Maximum_Length->FldTagCaption(1) <> "" ? $this->Password_Must_Comply_With_Maximum_Length->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Comply_With_Maximum_Length->ViewCustomAttributes = "";

		// Password_Must_Contain_At_Least_One_Upper_Case
		if (ew_ConvertToBool($this->Password_Must_Contain_At_Least_One_Upper_Case->CurrentValue)) {
			$this->Password_Must_Contain_At_Least_One_Upper_Case->ViewValue = $this->Password_Must_Contain_At_Least_One_Upper_Case->FldTagCaption(2) <> "" ? $this->Password_Must_Contain_At_Least_One_Upper_Case->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Contain_At_Least_One_Upper_Case->ViewValue = $this->Password_Must_Contain_At_Least_One_Upper_Case->FldTagCaption(1) <> "" ? $this->Password_Must_Contain_At_Least_One_Upper_Case->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Contain_At_Least_One_Upper_Case->ViewCustomAttributes = "";

		// Password_Must_Contain_At_Least_One_Numeric
		if (ew_ConvertToBool($this->Password_Must_Contain_At_Least_One_Numeric->CurrentValue)) {
			$this->Password_Must_Contain_At_Least_One_Numeric->ViewValue = $this->Password_Must_Contain_At_Least_One_Numeric->FldTagCaption(2) <> "" ? $this->Password_Must_Contain_At_Least_One_Numeric->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Contain_At_Least_One_Numeric->ViewValue = $this->Password_Must_Contain_At_Least_One_Numeric->FldTagCaption(1) <> "" ? $this->Password_Must_Contain_At_Least_One_Numeric->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Contain_At_Least_One_Numeric->ViewCustomAttributes = "";

		// Password_Must_Contain_At_Least_One_Symbol
		if (ew_ConvertToBool($this->Password_Must_Contain_At_Least_One_Symbol->CurrentValue)) {
			$this->Password_Must_Contain_At_Least_One_Symbol->ViewValue = $this->Password_Must_Contain_At_Least_One_Symbol->FldTagCaption(2) <> "" ? $this->Password_Must_Contain_At_Least_One_Symbol->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Contain_At_Least_One_Symbol->ViewValue = $this->Password_Must_Contain_At_Least_One_Symbol->FldTagCaption(1) <> "" ? $this->Password_Must_Contain_At_Least_One_Symbol->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Contain_At_Least_One_Symbol->ViewCustomAttributes = "";

		// Password_Must_Be_Difference_Between_Old_And_New
		if (ew_ConvertToBool($this->Password_Must_Be_Difference_Between_Old_And_New->CurrentValue)) {
			$this->Password_Must_Be_Difference_Between_Old_And_New->ViewValue = $this->Password_Must_Be_Difference_Between_Old_And_New->FldTagCaption(2) <> "" ? $this->Password_Must_Be_Difference_Between_Old_And_New->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Be_Difference_Between_Old_And_New->ViewValue = $this->Password_Must_Be_Difference_Between_Old_And_New->FldTagCaption(1) <> "" ? $this->Password_Must_Be_Difference_Between_Old_And_New->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Be_Difference_Between_Old_And_New->ViewCustomAttributes = "";

		// Reset_Password_Field_Options
		if (strval($this->Reset_Password_Field_Options->CurrentValue) <> "") {
			$this->Reset_Password_Field_Options->ViewValue = $this->Reset_Password_Field_Options->OptionCaption($this->Reset_Password_Field_Options->CurrentValue);
		} else {
			$this->Reset_Password_Field_Options->ViewValue = NULL;
		}
		$this->Reset_Password_Field_Options->ViewCustomAttributes = "";

		// Export_Record_Options
		if (strval($this->Export_Record_Options->CurrentValue) <> "") {
			$this->Export_Record_Options->ViewValue = $this->Export_Record_Options->OptionCaption($this->Export_Record_Options->CurrentValue);
		} else {
			$this->Export_Record_Options->ViewValue = NULL;
		}
		$this->Export_Record_Options->ViewCustomAttributes = "";

		// Show_Record_Number_On_Exported_List_Page
		if (ew_ConvertToBool($this->Show_Record_Number_On_Exported_List_Page->CurrentValue)) {
			$this->Show_Record_Number_On_Exported_List_Page->ViewValue = $this->Show_Record_Number_On_Exported_List_Page->FldTagCaption(2) <> "" ? $this->Show_Record_Number_On_Exported_List_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Record_Number_On_Exported_List_Page->ViewValue = $this->Show_Record_Number_On_Exported_List_Page->FldTagCaption(1) <> "" ? $this->Show_Record_Number_On_Exported_List_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Record_Number_On_Exported_List_Page->ViewCustomAttributes = "";

		// Use_Table_Setting_For_Export_Field_Caption
		if (ew_ConvertToBool($this->Use_Table_Setting_For_Export_Field_Caption->CurrentValue)) {
			$this->Use_Table_Setting_For_Export_Field_Caption->ViewValue = $this->Use_Table_Setting_For_Export_Field_Caption->FldTagCaption(2) <> "" ? $this->Use_Table_Setting_For_Export_Field_Caption->FldTagCaption(2) : "Yes";
		} else {
			$this->Use_Table_Setting_For_Export_Field_Caption->ViewValue = $this->Use_Table_Setting_For_Export_Field_Caption->FldTagCaption(1) <> "" ? $this->Use_Table_Setting_For_Export_Field_Caption->FldTagCaption(1) : "No";
		}
		$this->Use_Table_Setting_For_Export_Field_Caption->ViewCustomAttributes = "";

		// Use_Table_Setting_For_Export_Original_Value
		if (ew_ConvertToBool($this->Use_Table_Setting_For_Export_Original_Value->CurrentValue)) {
			$this->Use_Table_Setting_For_Export_Original_Value->ViewValue = $this->Use_Table_Setting_For_Export_Original_Value->FldTagCaption(2) <> "" ? $this->Use_Table_Setting_For_Export_Original_Value->FldTagCaption(2) : "Yes";
		} else {
			$this->Use_Table_Setting_For_Export_Original_Value->ViewValue = $this->Use_Table_Setting_For_Export_Original_Value->FldTagCaption(1) <> "" ? $this->Use_Table_Setting_For_Export_Original_Value->FldTagCaption(1) : "No";
		}
		$this->Use_Table_Setting_For_Export_Original_Value->ViewCustomAttributes = "";

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

			// Font_Name
			$this->Font_Name->LinkCustomAttributes = "";
			$this->Font_Name->HrefValue = "";
			$this->Font_Name->TooltipValue = "";

			// Font_Size
			$this->Font_Size->LinkCustomAttributes = "";
			$this->Font_Size->HrefValue = "";
			$this->Font_Size->TooltipValue = "";

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

			// Vertical_Menu_Width
			$this->Vertical_Menu_Width->LinkCustomAttributes = "";
			$this->Vertical_Menu_Width->HrefValue = "";
			$this->Vertical_Menu_Width->TooltipValue = "";

			// Show_Announcement
			$this->Show_Announcement->LinkCustomAttributes = "";
			$this->Show_Announcement->HrefValue = "";
			$this->Show_Announcement->TooltipValue = "";

			// Demo_Mode
			$this->Demo_Mode->LinkCustomAttributes = "";
			$this->Demo_Mode->HrefValue = "";
			$this->Demo_Mode->TooltipValue = "";

			// Show_Page_Processing_Time
			$this->Show_Page_Processing_Time->LinkCustomAttributes = "";
			$this->Show_Page_Processing_Time->HrefValue = "";
			$this->Show_Page_Processing_Time->TooltipValue = "";

			// Allow_User_Preferences
			$this->Allow_User_Preferences->LinkCustomAttributes = "";
			$this->Allow_User_Preferences->HrefValue = "";
			$this->Allow_User_Preferences->TooltipValue = "";

			// SMTP_Server
			$this->SMTP_Server->LinkCustomAttributes = "";
			$this->SMTP_Server->HrefValue = "";
			$this->SMTP_Server->TooltipValue = "";

			// SMTP_Server_Port
			$this->SMTP_Server_Port->LinkCustomAttributes = "";
			$this->SMTP_Server_Port->HrefValue = "";
			$this->SMTP_Server_Port->TooltipValue = "";

			// SMTP_Server_Username
			$this->SMTP_Server_Username->LinkCustomAttributes = "";
			$this->SMTP_Server_Username->HrefValue = "";
			$this->SMTP_Server_Username->TooltipValue = "";

			// SMTP_Server_Password
			$this->SMTP_Server_Password->LinkCustomAttributes = "";
			$this->SMTP_Server_Password->HrefValue = "";
			$this->SMTP_Server_Password->TooltipValue = "";

			// Sender_Email
			$this->Sender_Email->LinkCustomAttributes = "";
			$this->Sender_Email->HrefValue = "";
			$this->Sender_Email->TooltipValue = "";

			// Recipient_Email
			$this->Recipient_Email->LinkCustomAttributes = "";
			$this->Recipient_Email->HrefValue = "";
			$this->Recipient_Email->TooltipValue = "";

			// Use_Default_Locale
			$this->Use_Default_Locale->LinkCustomAttributes = "";
			$this->Use_Default_Locale->HrefValue = "";
			$this->Use_Default_Locale->TooltipValue = "";

			// Default_Language
			$this->Default_Language->LinkCustomAttributes = "";
			$this->Default_Language->HrefValue = "";
			$this->Default_Language->TooltipValue = "";

			// Default_Timezone
			$this->Default_Timezone->LinkCustomAttributes = "";
			$this->Default_Timezone->HrefValue = "";
			$this->Default_Timezone->TooltipValue = "";

			// Default_Thousands_Separator
			$this->Default_Thousands_Separator->LinkCustomAttributes = "";
			$this->Default_Thousands_Separator->HrefValue = "";
			$this->Default_Thousands_Separator->TooltipValue = "";

			// Default_Decimal_Point
			$this->Default_Decimal_Point->LinkCustomAttributes = "";
			$this->Default_Decimal_Point->HrefValue = "";
			$this->Default_Decimal_Point->TooltipValue = "";

			// Default_Currency_Symbol
			$this->Default_Currency_Symbol->LinkCustomAttributes = "";
			$this->Default_Currency_Symbol->HrefValue = "";
			$this->Default_Currency_Symbol->TooltipValue = "";

			// Default_Money_Thousands_Separator
			$this->Default_Money_Thousands_Separator->LinkCustomAttributes = "";
			$this->Default_Money_Thousands_Separator->HrefValue = "";
			$this->Default_Money_Thousands_Separator->TooltipValue = "";

			// Default_Money_Decimal_Point
			$this->Default_Money_Decimal_Point->LinkCustomAttributes = "";
			$this->Default_Money_Decimal_Point->HrefValue = "";
			$this->Default_Money_Decimal_Point->TooltipValue = "";

			// Maintenance_Mode
			$this->Maintenance_Mode->LinkCustomAttributes = "";
			$this->Maintenance_Mode->HrefValue = "";
			$this->Maintenance_Mode->TooltipValue = "";

			// Maintenance_Finish_DateTime
			$this->Maintenance_Finish_DateTime->LinkCustomAttributes = "";
			$this->Maintenance_Finish_DateTime->HrefValue = "";
			$this->Maintenance_Finish_DateTime->TooltipValue = "";

			// Auto_Normal_After_Maintenance
			$this->Auto_Normal_After_Maintenance->LinkCustomAttributes = "";
			$this->Auto_Normal_After_Maintenance->HrefValue = "";
			$this->Auto_Normal_After_Maintenance->TooltipValue = "";

			// Allow_User_To_Register
			$this->Allow_User_To_Register->LinkCustomAttributes = "";
			$this->Allow_User_To_Register->HrefValue = "";
			$this->Allow_User_To_Register->TooltipValue = "";

			// Suspend_New_User_Account
			$this->Suspend_New_User_Account->LinkCustomAttributes = "";
			$this->Suspend_New_User_Account->HrefValue = "";
			$this->Suspend_New_User_Account->TooltipValue = "";

			// User_Need_Activation_After_Registered
			$this->User_Need_Activation_After_Registered->LinkCustomAttributes = "";
			$this->User_Need_Activation_After_Registered->HrefValue = "";
			$this->User_Need_Activation_After_Registered->TooltipValue = "";

			// Show_Captcha_On_Registration_Page
			$this->Show_Captcha_On_Registration_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Registration_Page->HrefValue = "";
			$this->Show_Captcha_On_Registration_Page->TooltipValue = "";

			// Show_Terms_And_Conditions_On_Registration_Page
			$this->Show_Terms_And_Conditions_On_Registration_Page->LinkCustomAttributes = "";
			$this->Show_Terms_And_Conditions_On_Registration_Page->HrefValue = "";
			$this->Show_Terms_And_Conditions_On_Registration_Page->TooltipValue = "";

			// User_Auto_Login_After_Activation_Or_Registration
			$this->User_Auto_Login_After_Activation_Or_Registration->LinkCustomAttributes = "";
			$this->User_Auto_Login_After_Activation_Or_Registration->HrefValue = "";
			$this->User_Auto_Login_After_Activation_Or_Registration->TooltipValue = "";

			// Show_Captcha_On_Login_Page
			$this->Show_Captcha_On_Login_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Login_Page->HrefValue = "";
			$this->Show_Captcha_On_Login_Page->TooltipValue = "";

			// Show_Captcha_On_Forgot_Password_Page
			$this->Show_Captcha_On_Forgot_Password_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Forgot_Password_Page->HrefValue = "";
			$this->Show_Captcha_On_Forgot_Password_Page->TooltipValue = "";

			// Show_Captcha_On_Change_Password_Page
			$this->Show_Captcha_On_Change_Password_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Change_Password_Page->HrefValue = "";
			$this->Show_Captcha_On_Change_Password_Page->TooltipValue = "";

			// User_Auto_Logout_After_Idle_In_Minutes
			$this->User_Auto_Logout_After_Idle_In_Minutes->LinkCustomAttributes = "";
			$this->User_Auto_Logout_After_Idle_In_Minutes->HrefValue = "";
			$this->User_Auto_Logout_After_Idle_In_Minutes->TooltipValue = "";

			// User_Login_Maximum_Retry
			$this->User_Login_Maximum_Retry->LinkCustomAttributes = "";
			$this->User_Login_Maximum_Retry->HrefValue = "";
			$this->User_Login_Maximum_Retry->TooltipValue = "";

			// User_Login_Retry_Lockout
			$this->User_Login_Retry_Lockout->LinkCustomAttributes = "";
			$this->User_Login_Retry_Lockout->HrefValue = "";
			$this->User_Login_Retry_Lockout->TooltipValue = "";

			// Redirect_To_Last_Visited_Page_After_Login
			$this->Redirect_To_Last_Visited_Page_After_Login->LinkCustomAttributes = "";
			$this->Redirect_To_Last_Visited_Page_After_Login->HrefValue = "";
			$this->Redirect_To_Last_Visited_Page_After_Login->TooltipValue = "";

			// Enable_Password_Expiry
			$this->Enable_Password_Expiry->LinkCustomAttributes = "";
			$this->Enable_Password_Expiry->HrefValue = "";
			$this->Enable_Password_Expiry->TooltipValue = "";

			// Password_Expiry_In_Days
			$this->Password_Expiry_In_Days->LinkCustomAttributes = "";
			$this->Password_Expiry_In_Days->HrefValue = "";
			$this->Password_Expiry_In_Days->TooltipValue = "";

			// Show_Entire_Header
			$this->Show_Entire_Header->LinkCustomAttributes = "";
			$this->Show_Entire_Header->HrefValue = "";
			$this->Show_Entire_Header->TooltipValue = "";

			// Logo_Width
			$this->Logo_Width->LinkCustomAttributes = "";
			$this->Logo_Width->HrefValue = "";
			$this->Logo_Width->TooltipValue = "";

			// Show_Site_Title_In_Header
			$this->Show_Site_Title_In_Header->LinkCustomAttributes = "";
			$this->Show_Site_Title_In_Header->HrefValue = "";
			$this->Show_Site_Title_In_Header->TooltipValue = "";

			// Show_Current_User_In_Header
			$this->Show_Current_User_In_Header->LinkCustomAttributes = "";
			$this->Show_Current_User_In_Header->HrefValue = "";
			$this->Show_Current_User_In_Header->TooltipValue = "";

			// Text_Align_In_Header
			$this->Text_Align_In_Header->LinkCustomAttributes = "";
			$this->Text_Align_In_Header->HrefValue = "";
			$this->Text_Align_In_Header->TooltipValue = "";

			// Site_Title_Text_Style
			$this->Site_Title_Text_Style->LinkCustomAttributes = "";
			$this->Site_Title_Text_Style->HrefValue = "";
			$this->Site_Title_Text_Style->TooltipValue = "";

			// Language_Selector_Visibility
			$this->Language_Selector_Visibility->LinkCustomAttributes = "";
			$this->Language_Selector_Visibility->HrefValue = "";
			$this->Language_Selector_Visibility->TooltipValue = "";

			// Language_Selector_Align
			$this->Language_Selector_Align->LinkCustomAttributes = "";
			$this->Language_Selector_Align->HrefValue = "";
			$this->Language_Selector_Align->TooltipValue = "";

			// Show_Entire_Footer
			$this->Show_Entire_Footer->LinkCustomAttributes = "";
			$this->Show_Entire_Footer->HrefValue = "";
			$this->Show_Entire_Footer->TooltipValue = "";

			// Show_Text_In_Footer
			$this->Show_Text_In_Footer->LinkCustomAttributes = "";
			$this->Show_Text_In_Footer->HrefValue = "";
			$this->Show_Text_In_Footer->TooltipValue = "";

			// Show_Back_To_Top_On_Footer
			$this->Show_Back_To_Top_On_Footer->LinkCustomAttributes = "";
			$this->Show_Back_To_Top_On_Footer->HrefValue = "";
			$this->Show_Back_To_Top_On_Footer->TooltipValue = "";

			// Show_Terms_And_Conditions_On_Footer
			$this->Show_Terms_And_Conditions_On_Footer->LinkCustomAttributes = "";
			$this->Show_Terms_And_Conditions_On_Footer->HrefValue = "";
			$this->Show_Terms_And_Conditions_On_Footer->TooltipValue = "";

			// Show_About_Us_On_Footer
			$this->Show_About_Us_On_Footer->LinkCustomAttributes = "";
			$this->Show_About_Us_On_Footer->HrefValue = "";
			$this->Show_About_Us_On_Footer->TooltipValue = "";

			// Pagination_Position
			$this->Pagination_Position->LinkCustomAttributes = "";
			$this->Pagination_Position->HrefValue = "";
			$this->Pagination_Position->TooltipValue = "";

			// Pagination_Style
			$this->Pagination_Style->LinkCustomAttributes = "";
			$this->Pagination_Style->HrefValue = "";
			$this->Pagination_Style->TooltipValue = "";

			// Selectable_Records_Per_Page
			$this->Selectable_Records_Per_Page->LinkCustomAttributes = "";
			$this->Selectable_Records_Per_Page->HrefValue = "";
			$this->Selectable_Records_Per_Page->TooltipValue = "";

			// Selectable_Groups_Per_Page
			$this->Selectable_Groups_Per_Page->LinkCustomAttributes = "";
			$this->Selectable_Groups_Per_Page->HrefValue = "";
			$this->Selectable_Groups_Per_Page->TooltipValue = "";

			// Default_Record_Per_Page
			$this->Default_Record_Per_Page->LinkCustomAttributes = "";
			$this->Default_Record_Per_Page->HrefValue = "";
			$this->Default_Record_Per_Page->TooltipValue = "";

			// Default_Group_Per_Page
			$this->Default_Group_Per_Page->LinkCustomAttributes = "";
			$this->Default_Group_Per_Page->HrefValue = "";
			$this->Default_Group_Per_Page->TooltipValue = "";

			// Maximum_Selected_Records
			$this->Maximum_Selected_Records->LinkCustomAttributes = "";
			$this->Maximum_Selected_Records->HrefValue = "";
			$this->Maximum_Selected_Records->TooltipValue = "";

			// Maximum_Selected_Groups
			$this->Maximum_Selected_Groups->LinkCustomAttributes = "";
			$this->Maximum_Selected_Groups->HrefValue = "";
			$this->Maximum_Selected_Groups->TooltipValue = "";

			// Show_PageNum_If_Record_Not_Over_Pagesize
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->LinkCustomAttributes = "";
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->HrefValue = "";
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->TooltipValue = "";

			// Table_Width_Style
			$this->Table_Width_Style->LinkCustomAttributes = "";
			$this->Table_Width_Style->HrefValue = "";
			$this->Table_Width_Style->TooltipValue = "";

			// Scroll_Table_Width
			$this->Scroll_Table_Width->LinkCustomAttributes = "";
			$this->Scroll_Table_Width->HrefValue = "";
			$this->Scroll_Table_Width->TooltipValue = "";

			// Scroll_Table_Height
			$this->Scroll_Table_Height->LinkCustomAttributes = "";
			$this->Scroll_Table_Height->HrefValue = "";
			$this->Scroll_Table_Height->TooltipValue = "";

			// Search_Panel_Collapsed
			$this->Search_Panel_Collapsed->LinkCustomAttributes = "";
			$this->Search_Panel_Collapsed->HrefValue = "";
			$this->Search_Panel_Collapsed->TooltipValue = "";

			// Filter_Panel_Collapsed
			$this->Filter_Panel_Collapsed->LinkCustomAttributes = "";
			$this->Filter_Panel_Collapsed->HrefValue = "";
			$this->Filter_Panel_Collapsed->TooltipValue = "";

			// Show_Record_Number_On_List_Page
			$this->Show_Record_Number_On_List_Page->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_List_Page->HrefValue = "";
			$this->Show_Record_Number_On_List_Page->TooltipValue = "";

			// Show_Empty_Table_On_List_Page
			$this->Show_Empty_Table_On_List_Page->LinkCustomAttributes = "";
			$this->Show_Empty_Table_On_List_Page->HrefValue = "";
			$this->Show_Empty_Table_On_List_Page->TooltipValue = "";

			// Rows_Vertical_Align_Top
			$this->Rows_Vertical_Align_Top->LinkCustomAttributes = "";
			$this->Rows_Vertical_Align_Top->HrefValue = "";
			$this->Rows_Vertical_Align_Top->TooltipValue = "";

			// Action_Button_Alignment
			$this->Action_Button_Alignment->LinkCustomAttributes = "";
			$this->Action_Button_Alignment->HrefValue = "";
			$this->Action_Button_Alignment->TooltipValue = "";

			// Show_Add_Success_Message
			$this->Show_Add_Success_Message->LinkCustomAttributes = "";
			$this->Show_Add_Success_Message->HrefValue = "";
			$this->Show_Add_Success_Message->TooltipValue = "";

			// Show_Edit_Success_Message
			$this->Show_Edit_Success_Message->LinkCustomAttributes = "";
			$this->Show_Edit_Success_Message->HrefValue = "";
			$this->Show_Edit_Success_Message->TooltipValue = "";

			// jQuery_Auto_Hide_Success_Message
			$this->jQuery_Auto_Hide_Success_Message->LinkCustomAttributes = "";
			$this->jQuery_Auto_Hide_Success_Message->HrefValue = "";
			$this->jQuery_Auto_Hide_Success_Message->TooltipValue = "";

			// Use_Javascript_Message
			$this->Use_Javascript_Message->LinkCustomAttributes = "";
			$this->Use_Javascript_Message->HrefValue = "";
			$this->Use_Javascript_Message->TooltipValue = "";

			// Login_Window_Type
			$this->Login_Window_Type->LinkCustomAttributes = "";
			$this->Login_Window_Type->HrefValue = "";
			$this->Login_Window_Type->TooltipValue = "";

			// Forgot_Password_Window_Type
			$this->Forgot_Password_Window_Type->LinkCustomAttributes = "";
			$this->Forgot_Password_Window_Type->HrefValue = "";
			$this->Forgot_Password_Window_Type->TooltipValue = "";

			// Change_Password_Window_Type
			$this->Change_Password_Window_Type->LinkCustomAttributes = "";
			$this->Change_Password_Window_Type->HrefValue = "";
			$this->Change_Password_Window_Type->TooltipValue = "";

			// Registration_Window_Type
			$this->Registration_Window_Type->LinkCustomAttributes = "";
			$this->Registration_Window_Type->HrefValue = "";
			$this->Registration_Window_Type->TooltipValue = "";

			// Show_Record_Number_On_Detail_Preview
			$this->Show_Record_Number_On_Detail_Preview->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_Detail_Preview->HrefValue = "";
			$this->Show_Record_Number_On_Detail_Preview->TooltipValue = "";

			// Show_Empty_Table_In_Detail_Preview
			$this->Show_Empty_Table_In_Detail_Preview->LinkCustomAttributes = "";
			$this->Show_Empty_Table_In_Detail_Preview->HrefValue = "";
			$this->Show_Empty_Table_In_Detail_Preview->TooltipValue = "";

			// Detail_Preview_Table_Width
			$this->Detail_Preview_Table_Width->LinkCustomAttributes = "";
			$this->Detail_Preview_Table_Width->HrefValue = "";
			$this->Detail_Preview_Table_Width->TooltipValue = "";

			// Password_Minimum_Length
			$this->Password_Minimum_Length->LinkCustomAttributes = "";
			$this->Password_Minimum_Length->HrefValue = "";
			$this->Password_Minimum_Length->TooltipValue = "";

			// Password_Maximum_Length
			$this->Password_Maximum_Length->LinkCustomAttributes = "";
			$this->Password_Maximum_Length->HrefValue = "";
			$this->Password_Maximum_Length->TooltipValue = "";

			// Password_Must_Contain_At_Least_One_Lower_Case
			$this->Password_Must_Contain_At_Least_One_Lower_Case->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Lower_Case->HrefValue = "";
			$this->Password_Must_Contain_At_Least_One_Lower_Case->TooltipValue = "";

			// Password_Must_Comply_With_Minumum_Length
			$this->Password_Must_Comply_With_Minumum_Length->LinkCustomAttributes = "";
			$this->Password_Must_Comply_With_Minumum_Length->HrefValue = "";
			$this->Password_Must_Comply_With_Minumum_Length->TooltipValue = "";

			// Password_Must_Comply_With_Maximum_Length
			$this->Password_Must_Comply_With_Maximum_Length->LinkCustomAttributes = "";
			$this->Password_Must_Comply_With_Maximum_Length->HrefValue = "";
			$this->Password_Must_Comply_With_Maximum_Length->TooltipValue = "";

			// Password_Must_Contain_At_Least_One_Upper_Case
			$this->Password_Must_Contain_At_Least_One_Upper_Case->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Upper_Case->HrefValue = "";
			$this->Password_Must_Contain_At_Least_One_Upper_Case->TooltipValue = "";

			// Password_Must_Contain_At_Least_One_Numeric
			$this->Password_Must_Contain_At_Least_One_Numeric->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Numeric->HrefValue = "";
			$this->Password_Must_Contain_At_Least_One_Numeric->TooltipValue = "";

			// Password_Must_Contain_At_Least_One_Symbol
			$this->Password_Must_Contain_At_Least_One_Symbol->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Symbol->HrefValue = "";
			$this->Password_Must_Contain_At_Least_One_Symbol->TooltipValue = "";

			// Password_Must_Be_Difference_Between_Old_And_New
			$this->Password_Must_Be_Difference_Between_Old_And_New->LinkCustomAttributes = "";
			$this->Password_Must_Be_Difference_Between_Old_And_New->HrefValue = "";
			$this->Password_Must_Be_Difference_Between_Old_And_New->TooltipValue = "";

			// Reset_Password_Field_Options
			$this->Reset_Password_Field_Options->LinkCustomAttributes = "";
			$this->Reset_Password_Field_Options->HrefValue = "";
			$this->Reset_Password_Field_Options->TooltipValue = "";

			// Export_Record_Options
			$this->Export_Record_Options->LinkCustomAttributes = "";
			$this->Export_Record_Options->HrefValue = "";
			$this->Export_Record_Options->TooltipValue = "";

			// Show_Record_Number_On_Exported_List_Page
			$this->Show_Record_Number_On_Exported_List_Page->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_Exported_List_Page->HrefValue = "";
			$this->Show_Record_Number_On_Exported_List_Page->TooltipValue = "";

			// Use_Table_Setting_For_Export_Field_Caption
			$this->Use_Table_Setting_For_Export_Field_Caption->LinkCustomAttributes = "";
			$this->Use_Table_Setting_For_Export_Field_Caption->HrefValue = "";
			$this->Use_Table_Setting_For_Export_Field_Caption->TooltipValue = "";

			// Use_Table_Setting_For_Export_Original_Value
			$this->Use_Table_Setting_For_Export_Original_Value->LinkCustomAttributes = "";
			$this->Use_Table_Setting_For_Export_Original_Value->HrefValue = "";
			$this->Use_Table_Setting_For_Export_Original_Value->TooltipValue = "";
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

				$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Excel
        if ($Security->CanExportToExcel() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("excel");

			// $item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

				$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Word
        if ($Security->CanExportToWord() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("word");

			// $item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

				$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Html
        if ($Security->CanExportToHTML() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("html");

			// $item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

				$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHTML") . "</a>";

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Xml
        if ($Security->CanExportToXML() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("xml");

			// $item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

				$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXML") . "</a>";

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Csv
        if ($Security->CanExportToCSV() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("csv");

			// $item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

				$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCSV") . "</a>";

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Pdf
        if ($Security->CanExportToPDF() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("pdf");

			// $item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
			// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012

				$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\"  data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";

			// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
			$item->Visible = TRUE;
        }

		// Export to Email
		if ($Security->CanExportToEmail() || $Security->IsAdmin() ) {
			$item = &$this->ExportOptions->Add("email");
			$url = "";
			$item->Body = "<button id=\"emf_settings\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_settings',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fsettingsview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

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
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
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
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
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

		// Add record key QueryString
		$sQry .= "&" . substr($this->KeyUrl("", ""), 1);
		return $sQry;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("settingslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url); // v11.0.4
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$pages->Add(4);
		$pages->Add(5);
		$pages->Add(6);
		$pages->Add(7);
		$pages->Add(8);
		$pages->Add(9);
		$pages->Add(10);
		$pages->Add(11);
		$pages->Add(12);
		$pages->Add(13);
		$pages->Add(14);
		$this->MultiPages = $pages;
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
if (!isset($settings_view)) $settings_view = new csettings_view();

// Page init
$settings_view->Page_Init();

// Page main
$settings_view->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$settings_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fsettingsview = new ew_Form("fsettingsview", "view");

// Form_CustomValidate event
fsettingsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsettingsview.ValidateRequired = true;
<?php } else { ?>
fsettingsview.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fsettingsview.MultiPage = new ew_MultiPage("fsettingsview");

// Dynamic selection lists
fsettingsview.Lists["x_Option_Default[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Option_Default[]"].Options = <?php echo json_encode($settings->Option_Default->Options()) ?>;
fsettingsview.Lists["x_Default_Theme"] = {"LinkField":"x_Theme_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Theme_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Font_Name"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Font_Name"].Options = <?php echo json_encode($settings->Font_Name->Options()) ?>;
fsettingsview.Lists["x_Font_Size"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Font_Size"].Options = <?php echo json_encode($settings->Font_Size->Options()) ?>;
fsettingsview.Lists["x_Show_Border_Layout[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Border_Layout[]"].Options = <?php echo json_encode($settings->Show_Border_Layout->Options()) ?>;
fsettingsview.Lists["x_Show_Shadow_Layout[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Shadow_Layout[]"].Options = <?php echo json_encode($settings->Show_Shadow_Layout->Options()) ?>;
fsettingsview.Lists["x_Menu_Horizontal[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Menu_Horizontal[]"].Options = <?php echo json_encode($settings->Menu_Horizontal->Options()) ?>;
fsettingsview.Lists["x_Show_Announcement"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Announcement"].Options = <?php echo json_encode($settings->Show_Announcement->Options()) ?>;
fsettingsview.Lists["x_Demo_Mode[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Demo_Mode[]"].Options = <?php echo json_encode($settings->Demo_Mode->Options()) ?>;
fsettingsview.Lists["x_Show_Page_Processing_Time[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Page_Processing_Time[]"].Options = <?php echo json_encode($settings->Show_Page_Processing_Time->Options()) ?>;
fsettingsview.Lists["x_Allow_User_Preferences[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Allow_User_Preferences[]"].Options = <?php echo json_encode($settings->Allow_User_Preferences->Options()) ?>;
fsettingsview.Lists["x_Use_Default_Locale[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Use_Default_Locale[]"].Options = <?php echo json_encode($settings->Use_Default_Locale->Options()) ?>;
fsettingsview.Lists["x_Default_Language"] = {"LinkField":"x_Language_Code","Ajax":true,"AutoFill":false,"DisplayFields":["x_Language_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Default_Timezone"] = {"LinkField":"x_Timezone","Ajax":true,"AutoFill":false,"DisplayFields":["x_Timezone","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Maintenance_Mode[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Maintenance_Mode[]"].Options = <?php echo json_encode($settings->Maintenance_Mode->Options()) ?>;
fsettingsview.Lists["x_Auto_Normal_After_Maintenance[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Auto_Normal_After_Maintenance[]"].Options = <?php echo json_encode($settings->Auto_Normal_After_Maintenance->Options()) ?>;
fsettingsview.Lists["x_Allow_User_To_Register[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Allow_User_To_Register[]"].Options = <?php echo json_encode($settings->Allow_User_To_Register->Options()) ?>;
fsettingsview.Lists["x_Suspend_New_User_Account[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Suspend_New_User_Account[]"].Options = <?php echo json_encode($settings->Suspend_New_User_Account->Options()) ?>;
fsettingsview.Lists["x_User_Need_Activation_After_Registered[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_User_Need_Activation_After_Registered[]"].Options = <?php echo json_encode($settings->User_Need_Activation_After_Registered->Options()) ?>;
fsettingsview.Lists["x_Show_Captcha_On_Registration_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Captcha_On_Registration_Page[]"].Options = <?php echo json_encode($settings->Show_Captcha_On_Registration_Page->Options()) ?>;
fsettingsview.Lists["x_Show_Terms_And_Conditions_On_Registration_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Terms_And_Conditions_On_Registration_Page[]"].Options = <?php echo json_encode($settings->Show_Terms_And_Conditions_On_Registration_Page->Options()) ?>;
fsettingsview.Lists["x_User_Auto_Login_After_Activation_Or_Registration[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_User_Auto_Login_After_Activation_Or_Registration[]"].Options = <?php echo json_encode($settings->User_Auto_Login_After_Activation_Or_Registration->Options()) ?>;
fsettingsview.Lists["x_Show_Captcha_On_Login_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Captcha_On_Login_Page[]"].Options = <?php echo json_encode($settings->Show_Captcha_On_Login_Page->Options()) ?>;
fsettingsview.Lists["x_Show_Captcha_On_Forgot_Password_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Captcha_On_Forgot_Password_Page[]"].Options = <?php echo json_encode($settings->Show_Captcha_On_Forgot_Password_Page->Options()) ?>;
fsettingsview.Lists["x_Show_Captcha_On_Change_Password_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Captcha_On_Change_Password_Page[]"].Options = <?php echo json_encode($settings->Show_Captcha_On_Change_Password_Page->Options()) ?>;
fsettingsview.Lists["x_Redirect_To_Last_Visited_Page_After_Login[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Redirect_To_Last_Visited_Page_After_Login[]"].Options = <?php echo json_encode($settings->Redirect_To_Last_Visited_Page_After_Login->Options()) ?>;
fsettingsview.Lists["x_Enable_Password_Expiry[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Enable_Password_Expiry[]"].Options = <?php echo json_encode($settings->Enable_Password_Expiry->Options()) ?>;
fsettingsview.Lists["x_Show_Entire_Header[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Entire_Header[]"].Options = <?php echo json_encode($settings->Show_Entire_Header->Options()) ?>;
fsettingsview.Lists["x_Show_Site_Title_In_Header[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Site_Title_In_Header[]"].Options = <?php echo json_encode($settings->Show_Site_Title_In_Header->Options()) ?>;
fsettingsview.Lists["x_Show_Current_User_In_Header[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Current_User_In_Header[]"].Options = <?php echo json_encode($settings->Show_Current_User_In_Header->Options()) ?>;
fsettingsview.Lists["x_Text_Align_In_Header"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Text_Align_In_Header"].Options = <?php echo json_encode($settings->Text_Align_In_Header->Options()) ?>;
fsettingsview.Lists["x_Site_Title_Text_Style"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Site_Title_Text_Style"].Options = <?php echo json_encode($settings->Site_Title_Text_Style->Options()) ?>;
fsettingsview.Lists["x_Language_Selector_Visibility"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Language_Selector_Visibility"].Options = <?php echo json_encode($settings->Language_Selector_Visibility->Options()) ?>;
fsettingsview.Lists["x_Language_Selector_Align"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Language_Selector_Align"].Options = <?php echo json_encode($settings->Language_Selector_Align->Options()) ?>;
fsettingsview.Lists["x_Show_Entire_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Entire_Footer[]"].Options = <?php echo json_encode($settings->Show_Entire_Footer->Options()) ?>;
fsettingsview.Lists["x_Show_Text_In_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Text_In_Footer[]"].Options = <?php echo json_encode($settings->Show_Text_In_Footer->Options()) ?>;
fsettingsview.Lists["x_Show_Back_To_Top_On_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Back_To_Top_On_Footer[]"].Options = <?php echo json_encode($settings->Show_Back_To_Top_On_Footer->Options()) ?>;
fsettingsview.Lists["x_Show_Terms_And_Conditions_On_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Terms_And_Conditions_On_Footer[]"].Options = <?php echo json_encode($settings->Show_Terms_And_Conditions_On_Footer->Options()) ?>;
fsettingsview.Lists["x_Show_About_Us_On_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_About_Us_On_Footer[]"].Options = <?php echo json_encode($settings->Show_About_Us_On_Footer->Options()) ?>;
fsettingsview.Lists["x_Pagination_Position"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Pagination_Position"].Options = <?php echo json_encode($settings->Pagination_Position->Options()) ?>;
fsettingsview.Lists["x_Pagination_Style"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Pagination_Style"].Options = <?php echo json_encode($settings->Pagination_Style->Options()) ?>;
fsettingsview.Lists["x_Show_PageNum_If_Record_Not_Over_Pagesize[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_PageNum_If_Record_Not_Over_Pagesize[]"].Options = <?php echo json_encode($settings->Show_PageNum_If_Record_Not_Over_Pagesize->Options()) ?>;
fsettingsview.Lists["x_Table_Width_Style"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Table_Width_Style"].Options = <?php echo json_encode($settings->Table_Width_Style->Options()) ?>;
fsettingsview.Lists["x_Search_Panel_Collapsed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Search_Panel_Collapsed[]"].Options = <?php echo json_encode($settings->Search_Panel_Collapsed->Options()) ?>;
fsettingsview.Lists["x_Filter_Panel_Collapsed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Filter_Panel_Collapsed[]"].Options = <?php echo json_encode($settings->Filter_Panel_Collapsed->Options()) ?>;
fsettingsview.Lists["x_Show_Record_Number_On_List_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Record_Number_On_List_Page[]"].Options = <?php echo json_encode($settings->Show_Record_Number_On_List_Page->Options()) ?>;
fsettingsview.Lists["x_Show_Empty_Table_On_List_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Empty_Table_On_List_Page[]"].Options = <?php echo json_encode($settings->Show_Empty_Table_On_List_Page->Options()) ?>;
fsettingsview.Lists["x_Rows_Vertical_Align_Top[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Rows_Vertical_Align_Top[]"].Options = <?php echo json_encode($settings->Rows_Vertical_Align_Top->Options()) ?>;
fsettingsview.Lists["x_Action_Button_Alignment"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Action_Button_Alignment"].Options = <?php echo json_encode($settings->Action_Button_Alignment->Options()) ?>;
fsettingsview.Lists["x_Show_Add_Success_Message[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Add_Success_Message[]"].Options = <?php echo json_encode($settings->Show_Add_Success_Message->Options()) ?>;
fsettingsview.Lists["x_Show_Edit_Success_Message[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Edit_Success_Message[]"].Options = <?php echo json_encode($settings->Show_Edit_Success_Message->Options()) ?>;
fsettingsview.Lists["x_jQuery_Auto_Hide_Success_Message[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_jQuery_Auto_Hide_Success_Message[]"].Options = <?php echo json_encode($settings->jQuery_Auto_Hide_Success_Message->Options()) ?>;
fsettingsview.Lists["x_Use_Javascript_Message[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Use_Javascript_Message[]"].Options = <?php echo json_encode($settings->Use_Javascript_Message->Options()) ?>;
fsettingsview.Lists["x_Login_Window_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Login_Window_Type"].Options = <?php echo json_encode($settings->Login_Window_Type->Options()) ?>;
fsettingsview.Lists["x_Forgot_Password_Window_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Forgot_Password_Window_Type"].Options = <?php echo json_encode($settings->Forgot_Password_Window_Type->Options()) ?>;
fsettingsview.Lists["x_Change_Password_Window_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Change_Password_Window_Type"].Options = <?php echo json_encode($settings->Change_Password_Window_Type->Options()) ?>;
fsettingsview.Lists["x_Registration_Window_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Registration_Window_Type"].Options = <?php echo json_encode($settings->Registration_Window_Type->Options()) ?>;
fsettingsview.Lists["x_Show_Record_Number_On_Detail_Preview[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Record_Number_On_Detail_Preview[]"].Options = <?php echo json_encode($settings->Show_Record_Number_On_Detail_Preview->Options()) ?>;
fsettingsview.Lists["x_Show_Empty_Table_In_Detail_Preview[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Empty_Table_In_Detail_Preview[]"].Options = <?php echo json_encode($settings->Show_Empty_Table_In_Detail_Preview->Options()) ?>;
fsettingsview.Lists["x_Password_Must_Contain_At_Least_One_Lower_Case[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Password_Must_Contain_At_Least_One_Lower_Case[]"].Options = <?php echo json_encode($settings->Password_Must_Contain_At_Least_One_Lower_Case->Options()) ?>;
fsettingsview.Lists["x_Password_Must_Comply_With_Minumum_Length[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Password_Must_Comply_With_Minumum_Length[]"].Options = <?php echo json_encode($settings->Password_Must_Comply_With_Minumum_Length->Options()) ?>;
fsettingsview.Lists["x_Password_Must_Comply_With_Maximum_Length[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Password_Must_Comply_With_Maximum_Length[]"].Options = <?php echo json_encode($settings->Password_Must_Comply_With_Maximum_Length->Options()) ?>;
fsettingsview.Lists["x_Password_Must_Contain_At_Least_One_Upper_Case[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Password_Must_Contain_At_Least_One_Upper_Case[]"].Options = <?php echo json_encode($settings->Password_Must_Contain_At_Least_One_Upper_Case->Options()) ?>;
fsettingsview.Lists["x_Password_Must_Contain_At_Least_One_Numeric[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Password_Must_Contain_At_Least_One_Numeric[]"].Options = <?php echo json_encode($settings->Password_Must_Contain_At_Least_One_Numeric->Options()) ?>;
fsettingsview.Lists["x_Password_Must_Contain_At_Least_One_Symbol[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Password_Must_Contain_At_Least_One_Symbol[]"].Options = <?php echo json_encode($settings->Password_Must_Contain_At_Least_One_Symbol->Options()) ?>;
fsettingsview.Lists["x_Password_Must_Be_Difference_Between_Old_And_New[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Password_Must_Be_Difference_Between_Old_And_New[]"].Options = <?php echo json_encode($settings->Password_Must_Be_Difference_Between_Old_And_New->Options()) ?>;
fsettingsview.Lists["x_Reset_Password_Field_Options"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Reset_Password_Field_Options"].Options = <?php echo json_encode($settings->Reset_Password_Field_Options->Options()) ?>;
fsettingsview.Lists["x_Export_Record_Options"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Export_Record_Options"].Options = <?php echo json_encode($settings->Export_Record_Options->Options()) ?>;
fsettingsview.Lists["x_Show_Record_Number_On_Exported_List_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Show_Record_Number_On_Exported_List_Page[]"].Options = <?php echo json_encode($settings->Show_Record_Number_On_Exported_List_Page->Options()) ?>;
fsettingsview.Lists["x_Use_Table_Setting_For_Export_Field_Caption[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Use_Table_Setting_For_Export_Field_Caption[]"].Options = <?php echo json_encode($settings->Use_Table_Setting_For_Export_Field_Caption->Options()) ?>;
fsettingsview.Lists["x_Use_Table_Setting_For_Export_Original_Value[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsview.Lists["x_Use_Table_Setting_For_Export_Original_Value[]"].Options = <?php echo json_encode($settings->Use_Table_Setting_For_Export_Original_Value->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($settings->Export == "") { ?>
<div class="ewToolbar">
<?php if ($settings->Export == "") { ?>
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php } ?>
<?php $settings_view->ExportOptions->Render("body") ?>
<?php
	foreach ($settings_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($settings->Export == "") { ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $settings_view->ShowPageHeader(); ?>
<?php
$settings_view->ShowMessage();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<?php if ($settings->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($settings_view->Pager)) $settings_view->Pager = new cNumericPager($settings_view->StartRec, $settings_view->DisplayRecs, $settings_view->TotalRecs, $settings_view->RecRange) ?>
		<?php if ($settings_view->Pager->RecordCount > 0) { ?>
				<?php if (($settings_view->Pager->PageCount==1) && ($settings_view->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $settings_view->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $settings_view->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $settings_view->Pager->RecordCount ?></span>
				</div>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($settings_view->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_view->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($settings_view->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $settings_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($settings_view->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_view->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($settings_view->Pager)) $settings_view->Pager = new cPrevNextPager($settings_view->StartRec, $settings_view->DisplayRecs, $settings_view->TotalRecs) ?>
		<?php if ($settings_view->Pager->RecordCount > 0) { ?>
				<?php if (($settings_view->Pager->PageCount==1) && ($settings_view->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
						<div class="ewPager ewRec">
							<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $settings_view->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $settings_view->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $settings_view->Pager->RecordCount ?></span>
						</div>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($settings_view->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($settings_view->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $settings_view->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($settings_view->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($settings_view->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $settings_view->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fsettingsview" id="fsettingsview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($settings_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $settings_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="settings">
<?php if ($settings->Export == "") { ?>
<?php // Begin of Fixed template from PHPMaker author, July 17, 2014 ?>
<div class="ewMultiPage">
<?php // End of Fixed template from PHPMaker author, July 17, 2014 ?>
<div class="tabbable" id="settings_view">
	<ul class="nav<?php echo $settings_view->MultiPages->NavStyle() ?>">
		<li<?php echo $settings_view->MultiPages->TabStyle("1") ?>><a href="#tab_settings1" data-toggle="tab"><?php echo $settings->PageCaption(1) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("2") ?>><a href="#tab_settings2" data-toggle="tab"><?php echo $settings->PageCaption(2) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("3") ?>><a href="#tab_settings3" data-toggle="tab"><?php echo $settings->PageCaption(3) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("4") ?>><a href="#tab_settings4" data-toggle="tab"><?php echo $settings->PageCaption(4) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("5") ?>><a href="#tab_settings5" data-toggle="tab"><?php echo $settings->PageCaption(5) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("6") ?>><a href="#tab_settings6" data-toggle="tab"><?php echo $settings->PageCaption(6) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("7") ?>><a href="#tab_settings7" data-toggle="tab"><?php echo $settings->PageCaption(7) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("8") ?>><a href="#tab_settings8" data-toggle="tab"><?php echo $settings->PageCaption(8) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("9") ?>><a href="#tab_settings9" data-toggle="tab"><?php echo $settings->PageCaption(9) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("10") ?>><a href="#tab_settings10" data-toggle="tab"><?php echo $settings->PageCaption(10) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("11") ?>><a href="#tab_settings11" data-toggle="tab"><?php echo $settings->PageCaption(11) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("12") ?>><a href="#tab_settings12" data-toggle="tab"><?php echo $settings->PageCaption(12) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("13") ?>><a href="#tab_settings13" data-toggle="tab"><?php echo $settings->PageCaption(13) ?></a></li>
		<li<?php echo $settings_view->MultiPages->TabStyle("14") ?>><a href="#tab_settings14" data-toggle="tab"><?php echo $settings->PageCaption(14) ?></a></li>
	</ul>
	<div class="tab-content">
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("1") ?>" id="tab_settings1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Option_ID->Visible) { // Option_ID ?>
	<tr id="r_Option_ID">
		<td><span id="elh_settings_Option_ID"><?php echo $settings->Option_ID->FldCaption() ?></span></td>
		<td data-name="Option_ID"<?php echo $settings->Option_ID->CellAttributes() ?>>
<span id="el_settings_Option_ID" data-page="1">
<span<?php echo $settings->Option_ID->ViewAttributes() ?>>
<?php echo $settings->Option_ID->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Option_Default->Visible) { // Option_Default ?>
	<tr id="r_Option_Default">
		<td><span id="elh_settings_Option_Default"><?php echo $settings->Option_Default->FldCaption() ?></span></td>
		<td data-name="Option_Default"<?php echo $settings->Option_Default->CellAttributes() ?>>
<span id="el_settings_Option_Default" data-page="1">
<span<?php echo $settings->Option_Default->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Option_Default->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Option_Default->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Option_Default->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Theme->Visible) { // Default_Theme ?>
	<tr id="r_Default_Theme">
		<td><span id="elh_settings_Default_Theme"><?php echo $settings->Default_Theme->FldCaption() ?></span></td>
		<td data-name="Default_Theme"<?php echo $settings->Default_Theme->CellAttributes() ?>>
<span id="el_settings_Default_Theme" data-page="1">
<span<?php echo $settings->Default_Theme->ViewAttributes() ?>>
<?php echo $settings->Default_Theme->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Font_Name->Visible) { // Font_Name ?>
	<tr id="r_Font_Name">
		<td><span id="elh_settings_Font_Name"><?php echo $settings->Font_Name->FldCaption() ?></span></td>
		<td data-name="Font_Name"<?php echo $settings->Font_Name->CellAttributes() ?>>
<span id="el_settings_Font_Name" data-page="1">
<span<?php echo $settings->Font_Name->ViewAttributes() ?>>
<?php echo $settings->Font_Name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Font_Size->Visible) { // Font_Size ?>
	<tr id="r_Font_Size">
		<td><span id="elh_settings_Font_Size"><?php echo $settings->Font_Size->FldCaption() ?></span></td>
		<td data-name="Font_Size"<?php echo $settings->Font_Size->CellAttributes() ?>>
<span id="el_settings_Font_Size" data-page="1">
<span<?php echo $settings->Font_Size->ViewAttributes() ?>>
<?php echo $settings->Font_Size->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Border_Layout->Visible) { // Show_Border_Layout ?>
	<tr id="r_Show_Border_Layout">
		<td><span id="elh_settings_Show_Border_Layout"><?php echo $settings->Show_Border_Layout->FldCaption() ?></span></td>
		<td data-name="Show_Border_Layout"<?php echo $settings->Show_Border_Layout->CellAttributes() ?>>
<span id="el_settings_Show_Border_Layout" data-page="1">
<span<?php echo $settings->Show_Border_Layout->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Border_Layout->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Border_Layout->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Border_Layout->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Shadow_Layout->Visible) { // Show_Shadow_Layout ?>
	<tr id="r_Show_Shadow_Layout">
		<td><span id="elh_settings_Show_Shadow_Layout"><?php echo $settings->Show_Shadow_Layout->FldCaption() ?></span></td>
		<td data-name="Show_Shadow_Layout"<?php echo $settings->Show_Shadow_Layout->CellAttributes() ?>>
<span id="el_settings_Show_Shadow_Layout" data-page="1">
<span<?php echo $settings->Show_Shadow_Layout->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Shadow_Layout->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Shadow_Layout->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Shadow_Layout->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Menu_Horizontal->Visible) { // Menu_Horizontal ?>
	<tr id="r_Menu_Horizontal">
		<td><span id="elh_settings_Menu_Horizontal"><?php echo $settings->Menu_Horizontal->FldCaption() ?></span></td>
		<td data-name="Menu_Horizontal"<?php echo $settings->Menu_Horizontal->CellAttributes() ?>>
<span id="el_settings_Menu_Horizontal" data-page="1">
<span<?php echo $settings->Menu_Horizontal->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Menu_Horizontal->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Menu_Horizontal->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Menu_Horizontal->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Vertical_Menu_Width->Visible) { // Vertical_Menu_Width ?>
	<tr id="r_Vertical_Menu_Width">
		<td><span id="elh_settings_Vertical_Menu_Width"><?php echo $settings->Vertical_Menu_Width->FldCaption() ?></span></td>
		<td data-name="Vertical_Menu_Width"<?php echo $settings->Vertical_Menu_Width->CellAttributes() ?>>
<span id="el_settings_Vertical_Menu_Width" data-page="1">
<span<?php echo $settings->Vertical_Menu_Width->ViewAttributes() ?>>
<?php echo $settings->Vertical_Menu_Width->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Announcement->Visible) { // Show_Announcement ?>
	<tr id="r_Show_Announcement">
		<td><span id="elh_settings_Show_Announcement"><?php echo $settings->Show_Announcement->FldCaption() ?></span></td>
		<td data-name="Show_Announcement"<?php echo $settings->Show_Announcement->CellAttributes() ?>>
<span id="el_settings_Show_Announcement" data-page="1">
<span<?php echo $settings->Show_Announcement->ViewAttributes() ?>>
<?php echo $settings->Show_Announcement->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Demo_Mode->Visible) { // Demo_Mode ?>
	<tr id="r_Demo_Mode">
		<td><span id="elh_settings_Demo_Mode"><?php echo $settings->Demo_Mode->FldCaption() ?></span></td>
		<td data-name="Demo_Mode"<?php echo $settings->Demo_Mode->CellAttributes() ?>>
<span id="el_settings_Demo_Mode" data-page="1">
<span<?php echo $settings->Demo_Mode->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Demo_Mode->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Demo_Mode->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Demo_Mode->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Page_Processing_Time->Visible) { // Show_Page_Processing_Time ?>
	<tr id="r_Show_Page_Processing_Time">
		<td><span id="elh_settings_Show_Page_Processing_Time"><?php echo $settings->Show_Page_Processing_Time->FldCaption() ?></span></td>
		<td data-name="Show_Page_Processing_Time"<?php echo $settings->Show_Page_Processing_Time->CellAttributes() ?>>
<span id="el_settings_Show_Page_Processing_Time" data-page="1">
<span<?php echo $settings->Show_Page_Processing_Time->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Page_Processing_Time->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Page_Processing_Time->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Page_Processing_Time->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Allow_User_Preferences->Visible) { // Allow_User_Preferences ?>
	<tr id="r_Allow_User_Preferences">
		<td><span id="elh_settings_Allow_User_Preferences"><?php echo $settings->Allow_User_Preferences->FldCaption() ?></span></td>
		<td data-name="Allow_User_Preferences"<?php echo $settings->Allow_User_Preferences->CellAttributes() ?>>
<span id="el_settings_Allow_User_Preferences" data-page="1">
<span<?php echo $settings->Allow_User_Preferences->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Allow_User_Preferences->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Allow_User_Preferences->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Allow_User_Preferences->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("2") ?>" id="tab_settings2">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->SMTP_Server->Visible) { // SMTP_Server ?>
	<tr id="r_SMTP_Server">
		<td><span id="elh_settings_SMTP_Server"><?php echo $settings->SMTP_Server->FldCaption() ?></span></td>
		<td data-name="SMTP_Server"<?php echo $settings->SMTP_Server->CellAttributes() ?>>
<span id="el_settings_SMTP_Server" data-page="2">
<span<?php echo $settings->SMTP_Server->ViewAttributes() ?>>
<?php echo $settings->SMTP_Server->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->SMTP_Server_Port->Visible) { // SMTP_Server_Port ?>
	<tr id="r_SMTP_Server_Port">
		<td><span id="elh_settings_SMTP_Server_Port"><?php echo $settings->SMTP_Server_Port->FldCaption() ?></span></td>
		<td data-name="SMTP_Server_Port"<?php echo $settings->SMTP_Server_Port->CellAttributes() ?>>
<span id="el_settings_SMTP_Server_Port" data-page="2">
<span<?php echo $settings->SMTP_Server_Port->ViewAttributes() ?>>
<?php echo $settings->SMTP_Server_Port->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->SMTP_Server_Username->Visible) { // SMTP_Server_Username ?>
	<tr id="r_SMTP_Server_Username">
		<td><span id="elh_settings_SMTP_Server_Username"><?php echo $settings->SMTP_Server_Username->FldCaption() ?></span></td>
		<td data-name="SMTP_Server_Username"<?php echo $settings->SMTP_Server_Username->CellAttributes() ?>>
<span id="el_settings_SMTP_Server_Username" data-page="2">
<span<?php echo $settings->SMTP_Server_Username->ViewAttributes() ?>>
<?php echo $settings->SMTP_Server_Username->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->SMTP_Server_Password->Visible) { // SMTP_Server_Password ?>
	<tr id="r_SMTP_Server_Password">
		<td><span id="elh_settings_SMTP_Server_Password"><?php echo $settings->SMTP_Server_Password->FldCaption() ?></span></td>
		<td data-name="SMTP_Server_Password"<?php echo $settings->SMTP_Server_Password->CellAttributes() ?>>
<span id="el_settings_SMTP_Server_Password" data-page="2">
<span<?php echo $settings->SMTP_Server_Password->ViewAttributes() ?>>
<?php echo $settings->SMTP_Server_Password->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Sender_Email->Visible) { // Sender_Email ?>
	<tr id="r_Sender_Email">
		<td><span id="elh_settings_Sender_Email"><?php echo $settings->Sender_Email->FldCaption() ?></span></td>
		<td data-name="Sender_Email"<?php echo $settings->Sender_Email->CellAttributes() ?>>
<span id="el_settings_Sender_Email" data-page="2">
<span<?php echo $settings->Sender_Email->ViewAttributes() ?>>
<?php echo $settings->Sender_Email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Recipient_Email->Visible) { // Recipient_Email ?>
	<tr id="r_Recipient_Email">
		<td><span id="elh_settings_Recipient_Email"><?php echo $settings->Recipient_Email->FldCaption() ?></span></td>
		<td data-name="Recipient_Email"<?php echo $settings->Recipient_Email->CellAttributes() ?>>
<span id="el_settings_Recipient_Email" data-page="2">
<span<?php echo $settings->Recipient_Email->ViewAttributes() ?>>
<?php echo $settings->Recipient_Email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("3") ?>" id="tab_settings3">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Use_Default_Locale->Visible) { // Use_Default_Locale ?>
	<tr id="r_Use_Default_Locale">
		<td><span id="elh_settings_Use_Default_Locale"><?php echo $settings->Use_Default_Locale->FldCaption() ?></span></td>
		<td data-name="Use_Default_Locale"<?php echo $settings->Use_Default_Locale->CellAttributes() ?>>
<span id="el_settings_Use_Default_Locale" data-page="3">
<span<?php echo $settings->Use_Default_Locale->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Use_Default_Locale->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Use_Default_Locale->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Use_Default_Locale->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Language->Visible) { // Default_Language ?>
	<tr id="r_Default_Language">
		<td><span id="elh_settings_Default_Language"><?php echo $settings->Default_Language->FldCaption() ?></span></td>
		<td data-name="Default_Language"<?php echo $settings->Default_Language->CellAttributes() ?>>
<span id="el_settings_Default_Language" data-page="3">
<span<?php echo $settings->Default_Language->ViewAttributes() ?>>
<?php echo $settings->Default_Language->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Timezone->Visible) { // Default_Timezone ?>
	<tr id="r_Default_Timezone">
		<td><span id="elh_settings_Default_Timezone"><?php echo $settings->Default_Timezone->FldCaption() ?></span></td>
		<td data-name="Default_Timezone"<?php echo $settings->Default_Timezone->CellAttributes() ?>>
<span id="el_settings_Default_Timezone" data-page="3">
<span<?php echo $settings->Default_Timezone->ViewAttributes() ?>>
<?php echo $settings->Default_Timezone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Thousands_Separator->Visible) { // Default_Thousands_Separator ?>
	<tr id="r_Default_Thousands_Separator">
		<td><span id="elh_settings_Default_Thousands_Separator"><?php echo $settings->Default_Thousands_Separator->FldCaption() ?></span></td>
		<td data-name="Default_Thousands_Separator"<?php echo $settings->Default_Thousands_Separator->CellAttributes() ?>>
<span id="el_settings_Default_Thousands_Separator" data-page="3">
<span<?php echo $settings->Default_Thousands_Separator->ViewAttributes() ?>>
<?php echo $settings->Default_Thousands_Separator->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Decimal_Point->Visible) { // Default_Decimal_Point ?>
	<tr id="r_Default_Decimal_Point">
		<td><span id="elh_settings_Default_Decimal_Point"><?php echo $settings->Default_Decimal_Point->FldCaption() ?></span></td>
		<td data-name="Default_Decimal_Point"<?php echo $settings->Default_Decimal_Point->CellAttributes() ?>>
<span id="el_settings_Default_Decimal_Point" data-page="3">
<span<?php echo $settings->Default_Decimal_Point->ViewAttributes() ?>>
<?php echo $settings->Default_Decimal_Point->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Currency_Symbol->Visible) { // Default_Currency_Symbol ?>
	<tr id="r_Default_Currency_Symbol">
		<td><span id="elh_settings_Default_Currency_Symbol"><?php echo $settings->Default_Currency_Symbol->FldCaption() ?></span></td>
		<td data-name="Default_Currency_Symbol"<?php echo $settings->Default_Currency_Symbol->CellAttributes() ?>>
<span id="el_settings_Default_Currency_Symbol" data-page="3">
<span<?php echo $settings->Default_Currency_Symbol->ViewAttributes() ?>>
<?php echo $settings->Default_Currency_Symbol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Money_Thousands_Separator->Visible) { // Default_Money_Thousands_Separator ?>
	<tr id="r_Default_Money_Thousands_Separator">
		<td><span id="elh_settings_Default_Money_Thousands_Separator"><?php echo $settings->Default_Money_Thousands_Separator->FldCaption() ?></span></td>
		<td data-name="Default_Money_Thousands_Separator"<?php echo $settings->Default_Money_Thousands_Separator->CellAttributes() ?>>
<span id="el_settings_Default_Money_Thousands_Separator" data-page="3">
<span<?php echo $settings->Default_Money_Thousands_Separator->ViewAttributes() ?>>
<?php echo $settings->Default_Money_Thousands_Separator->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Money_Decimal_Point->Visible) { // Default_Money_Decimal_Point ?>
	<tr id="r_Default_Money_Decimal_Point">
		<td><span id="elh_settings_Default_Money_Decimal_Point"><?php echo $settings->Default_Money_Decimal_Point->FldCaption() ?></span></td>
		<td data-name="Default_Money_Decimal_Point"<?php echo $settings->Default_Money_Decimal_Point->CellAttributes() ?>>
<span id="el_settings_Default_Money_Decimal_Point" data-page="3">
<span<?php echo $settings->Default_Money_Decimal_Point->ViewAttributes() ?>>
<?php echo $settings->Default_Money_Decimal_Point->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("4") ?>" id="tab_settings4">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Maintenance_Mode->Visible) { // Maintenance_Mode ?>
	<tr id="r_Maintenance_Mode">
		<td><span id="elh_settings_Maintenance_Mode"><?php echo $settings->Maintenance_Mode->FldCaption() ?></span></td>
		<td data-name="Maintenance_Mode"<?php echo $settings->Maintenance_Mode->CellAttributes() ?>>
<span id="el_settings_Maintenance_Mode" data-page="4">
<span<?php echo $settings->Maintenance_Mode->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Maintenance_Mode->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Maintenance_Mode->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Maintenance_Mode->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Maintenance_Finish_DateTime->Visible) { // Maintenance_Finish_DateTime ?>
	<tr id="r_Maintenance_Finish_DateTime">
		<td><span id="elh_settings_Maintenance_Finish_DateTime"><?php echo $settings->Maintenance_Finish_DateTime->FldCaption() ?></span></td>
		<td data-name="Maintenance_Finish_DateTime"<?php echo $settings->Maintenance_Finish_DateTime->CellAttributes() ?>>
<span id="el_settings_Maintenance_Finish_DateTime" data-page="4">
<span<?php echo $settings->Maintenance_Finish_DateTime->ViewAttributes() ?>>
<?php echo $settings->Maintenance_Finish_DateTime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Auto_Normal_After_Maintenance->Visible) { // Auto_Normal_After_Maintenance ?>
	<tr id="r_Auto_Normal_After_Maintenance">
		<td><span id="elh_settings_Auto_Normal_After_Maintenance"><?php echo $settings->Auto_Normal_After_Maintenance->FldCaption() ?></span></td>
		<td data-name="Auto_Normal_After_Maintenance"<?php echo $settings->Auto_Normal_After_Maintenance->CellAttributes() ?>>
<span id="el_settings_Auto_Normal_After_Maintenance" data-page="4">
<span<?php echo $settings->Auto_Normal_After_Maintenance->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Auto_Normal_After_Maintenance->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Auto_Normal_After_Maintenance->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Auto_Normal_After_Maintenance->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("5") ?>" id="tab_settings5">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Allow_User_To_Register->Visible) { // Allow_User_To_Register ?>
	<tr id="r_Allow_User_To_Register">
		<td><span id="elh_settings_Allow_User_To_Register"><?php echo $settings->Allow_User_To_Register->FldCaption() ?></span></td>
		<td data-name="Allow_User_To_Register"<?php echo $settings->Allow_User_To_Register->CellAttributes() ?>>
<span id="el_settings_Allow_User_To_Register" data-page="5">
<span<?php echo $settings->Allow_User_To_Register->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Allow_User_To_Register->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Allow_User_To_Register->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Allow_User_To_Register->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Suspend_New_User_Account->Visible) { // Suspend_New_User_Account ?>
	<tr id="r_Suspend_New_User_Account">
		<td><span id="elh_settings_Suspend_New_User_Account"><?php echo $settings->Suspend_New_User_Account->FldCaption() ?></span></td>
		<td data-name="Suspend_New_User_Account"<?php echo $settings->Suspend_New_User_Account->CellAttributes() ?>>
<span id="el_settings_Suspend_New_User_Account" data-page="5">
<span<?php echo $settings->Suspend_New_User_Account->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Suspend_New_User_Account->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Suspend_New_User_Account->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Suspend_New_User_Account->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->User_Need_Activation_After_Registered->Visible) { // User_Need_Activation_After_Registered ?>
	<tr id="r_User_Need_Activation_After_Registered">
		<td><span id="elh_settings_User_Need_Activation_After_Registered"><?php echo $settings->User_Need_Activation_After_Registered->FldCaption() ?></span></td>
		<td data-name="User_Need_Activation_After_Registered"<?php echo $settings->User_Need_Activation_After_Registered->CellAttributes() ?>>
<span id="el_settings_User_Need_Activation_After_Registered" data-page="5">
<span<?php echo $settings->User_Need_Activation_After_Registered->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->User_Need_Activation_After_Registered->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->User_Need_Activation_After_Registered->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->User_Need_Activation_After_Registered->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Captcha_On_Registration_Page->Visible) { // Show_Captcha_On_Registration_Page ?>
	<tr id="r_Show_Captcha_On_Registration_Page">
		<td><span id="elh_settings_Show_Captcha_On_Registration_Page"><?php echo $settings->Show_Captcha_On_Registration_Page->FldCaption() ?></span></td>
		<td data-name="Show_Captcha_On_Registration_Page"<?php echo $settings->Show_Captcha_On_Registration_Page->CellAttributes() ?>>
<span id="el_settings_Show_Captcha_On_Registration_Page" data-page="5">
<span<?php echo $settings->Show_Captcha_On_Registration_Page->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Captcha_On_Registration_Page->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Captcha_On_Registration_Page->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Captcha_On_Registration_Page->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Terms_And_Conditions_On_Registration_Page->Visible) { // Show_Terms_And_Conditions_On_Registration_Page ?>
	<tr id="r_Show_Terms_And_Conditions_On_Registration_Page">
		<td><span id="elh_settings_Show_Terms_And_Conditions_On_Registration_Page"><?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->FldCaption() ?></span></td>
		<td data-name="Show_Terms_And_Conditions_On_Registration_Page"<?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->CellAttributes() ?>>
<span id="el_settings_Show_Terms_And_Conditions_On_Registration_Page" data-page="5">
<span<?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Terms_And_Conditions_On_Registration_Page->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->User_Auto_Login_After_Activation_Or_Registration->Visible) { // User_Auto_Login_After_Activation_Or_Registration ?>
	<tr id="r_User_Auto_Login_After_Activation_Or_Registration">
		<td><span id="elh_settings_User_Auto_Login_After_Activation_Or_Registration"><?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->FldCaption() ?></span></td>
		<td data-name="User_Auto_Login_After_Activation_Or_Registration"<?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->CellAttributes() ?>>
<span id="el_settings_User_Auto_Login_After_Activation_Or_Registration" data-page="5">
<span<?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->User_Auto_Login_After_Activation_Or_Registration->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("6") ?>" id="tab_settings6">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Show_Captcha_On_Login_Page->Visible) { // Show_Captcha_On_Login_Page ?>
	<tr id="r_Show_Captcha_On_Login_Page">
		<td><span id="elh_settings_Show_Captcha_On_Login_Page"><?php echo $settings->Show_Captcha_On_Login_Page->FldCaption() ?></span></td>
		<td data-name="Show_Captcha_On_Login_Page"<?php echo $settings->Show_Captcha_On_Login_Page->CellAttributes() ?>>
<span id="el_settings_Show_Captcha_On_Login_Page" data-page="6">
<span<?php echo $settings->Show_Captcha_On_Login_Page->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Captcha_On_Login_Page->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Captcha_On_Login_Page->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Captcha_On_Login_Page->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Captcha_On_Forgot_Password_Page->Visible) { // Show_Captcha_On_Forgot_Password_Page ?>
	<tr id="r_Show_Captcha_On_Forgot_Password_Page">
		<td><span id="elh_settings_Show_Captcha_On_Forgot_Password_Page"><?php echo $settings->Show_Captcha_On_Forgot_Password_Page->FldCaption() ?></span></td>
		<td data-name="Show_Captcha_On_Forgot_Password_Page"<?php echo $settings->Show_Captcha_On_Forgot_Password_Page->CellAttributes() ?>>
<span id="el_settings_Show_Captcha_On_Forgot_Password_Page" data-page="6">
<span<?php echo $settings->Show_Captcha_On_Forgot_Password_Page->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Captcha_On_Forgot_Password_Page->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Captcha_On_Forgot_Password_Page->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Captcha_On_Forgot_Password_Page->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Captcha_On_Change_Password_Page->Visible) { // Show_Captcha_On_Change_Password_Page ?>
	<tr id="r_Show_Captcha_On_Change_Password_Page">
		<td><span id="elh_settings_Show_Captcha_On_Change_Password_Page"><?php echo $settings->Show_Captcha_On_Change_Password_Page->FldCaption() ?></span></td>
		<td data-name="Show_Captcha_On_Change_Password_Page"<?php echo $settings->Show_Captcha_On_Change_Password_Page->CellAttributes() ?>>
<span id="el_settings_Show_Captcha_On_Change_Password_Page" data-page="6">
<span<?php echo $settings->Show_Captcha_On_Change_Password_Page->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Captcha_On_Change_Password_Page->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Captcha_On_Change_Password_Page->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Captcha_On_Change_Password_Page->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->User_Auto_Logout_After_Idle_In_Minutes->Visible) { // User_Auto_Logout_After_Idle_In_Minutes ?>
	<tr id="r_User_Auto_Logout_After_Idle_In_Minutes">
		<td><span id="elh_settings_User_Auto_Logout_After_Idle_In_Minutes"><?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->FldCaption() ?></span></td>
		<td data-name="User_Auto_Logout_After_Idle_In_Minutes"<?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->CellAttributes() ?>>
<span id="el_settings_User_Auto_Logout_After_Idle_In_Minutes" data-page="6">
<span<?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->ViewAttributes() ?>>
<?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->User_Login_Maximum_Retry->Visible) { // User_Login_Maximum_Retry ?>
	<tr id="r_User_Login_Maximum_Retry">
		<td><span id="elh_settings_User_Login_Maximum_Retry"><?php echo $settings->User_Login_Maximum_Retry->FldCaption() ?></span></td>
		<td data-name="User_Login_Maximum_Retry"<?php echo $settings->User_Login_Maximum_Retry->CellAttributes() ?>>
<span id="el_settings_User_Login_Maximum_Retry" data-page="6">
<span<?php echo $settings->User_Login_Maximum_Retry->ViewAttributes() ?>>
<?php echo $settings->User_Login_Maximum_Retry->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->User_Login_Retry_Lockout->Visible) { // User_Login_Retry_Lockout ?>
	<tr id="r_User_Login_Retry_Lockout">
		<td><span id="elh_settings_User_Login_Retry_Lockout"><?php echo $settings->User_Login_Retry_Lockout->FldCaption() ?></span></td>
		<td data-name="User_Login_Retry_Lockout"<?php echo $settings->User_Login_Retry_Lockout->CellAttributes() ?>>
<span id="el_settings_User_Login_Retry_Lockout" data-page="6">
<span<?php echo $settings->User_Login_Retry_Lockout->ViewAttributes() ?>>
<?php echo $settings->User_Login_Retry_Lockout->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Redirect_To_Last_Visited_Page_After_Login->Visible) { // Redirect_To_Last_Visited_Page_After_Login ?>
	<tr id="r_Redirect_To_Last_Visited_Page_After_Login">
		<td><span id="elh_settings_Redirect_To_Last_Visited_Page_After_Login"><?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->FldCaption() ?></span></td>
		<td data-name="Redirect_To_Last_Visited_Page_After_Login"<?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->CellAttributes() ?>>
<span id="el_settings_Redirect_To_Last_Visited_Page_After_Login" data-page="6">
<span<?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Redirect_To_Last_Visited_Page_After_Login->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Enable_Password_Expiry->Visible) { // Enable_Password_Expiry ?>
	<tr id="r_Enable_Password_Expiry">
		<td><span id="elh_settings_Enable_Password_Expiry"><?php echo $settings->Enable_Password_Expiry->FldCaption() ?></span></td>
		<td data-name="Enable_Password_Expiry"<?php echo $settings->Enable_Password_Expiry->CellAttributes() ?>>
<span id="el_settings_Enable_Password_Expiry" data-page="6">
<span<?php echo $settings->Enable_Password_Expiry->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Enable_Password_Expiry->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Enable_Password_Expiry->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Enable_Password_Expiry->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Expiry_In_Days->Visible) { // Password_Expiry_In_Days ?>
	<tr id="r_Password_Expiry_In_Days">
		<td><span id="elh_settings_Password_Expiry_In_Days"><?php echo $settings->Password_Expiry_In_Days->FldCaption() ?></span></td>
		<td data-name="Password_Expiry_In_Days"<?php echo $settings->Password_Expiry_In_Days->CellAttributes() ?>>
<span id="el_settings_Password_Expiry_In_Days" data-page="6">
<span<?php echo $settings->Password_Expiry_In_Days->ViewAttributes() ?>>
<?php echo $settings->Password_Expiry_In_Days->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("7") ?>" id="tab_settings7">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Show_Entire_Header->Visible) { // Show_Entire_Header ?>
	<tr id="r_Show_Entire_Header">
		<td><span id="elh_settings_Show_Entire_Header"><?php echo $settings->Show_Entire_Header->FldCaption() ?></span></td>
		<td data-name="Show_Entire_Header"<?php echo $settings->Show_Entire_Header->CellAttributes() ?>>
<span id="el_settings_Show_Entire_Header" data-page="7">
<span<?php echo $settings->Show_Entire_Header->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Entire_Header->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Entire_Header->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Entire_Header->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Logo_Width->Visible) { // Logo_Width ?>
	<tr id="r_Logo_Width">
		<td><span id="elh_settings_Logo_Width"><?php echo $settings->Logo_Width->FldCaption() ?></span></td>
		<td data-name="Logo_Width"<?php echo $settings->Logo_Width->CellAttributes() ?>>
<span id="el_settings_Logo_Width" data-page="7">
<span<?php echo $settings->Logo_Width->ViewAttributes() ?>>
<?php echo $settings->Logo_Width->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Site_Title_In_Header->Visible) { // Show_Site_Title_In_Header ?>
	<tr id="r_Show_Site_Title_In_Header">
		<td><span id="elh_settings_Show_Site_Title_In_Header"><?php echo $settings->Show_Site_Title_In_Header->FldCaption() ?></span></td>
		<td data-name="Show_Site_Title_In_Header"<?php echo $settings->Show_Site_Title_In_Header->CellAttributes() ?>>
<span id="el_settings_Show_Site_Title_In_Header" data-page="7">
<span<?php echo $settings->Show_Site_Title_In_Header->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Site_Title_In_Header->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Site_Title_In_Header->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Site_Title_In_Header->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Current_User_In_Header->Visible) { // Show_Current_User_In_Header ?>
	<tr id="r_Show_Current_User_In_Header">
		<td><span id="elh_settings_Show_Current_User_In_Header"><?php echo $settings->Show_Current_User_In_Header->FldCaption() ?></span></td>
		<td data-name="Show_Current_User_In_Header"<?php echo $settings->Show_Current_User_In_Header->CellAttributes() ?>>
<span id="el_settings_Show_Current_User_In_Header" data-page="7">
<span<?php echo $settings->Show_Current_User_In_Header->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Current_User_In_Header->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Current_User_In_Header->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Current_User_In_Header->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Text_Align_In_Header->Visible) { // Text_Align_In_Header ?>
	<tr id="r_Text_Align_In_Header">
		<td><span id="elh_settings_Text_Align_In_Header"><?php echo $settings->Text_Align_In_Header->FldCaption() ?></span></td>
		<td data-name="Text_Align_In_Header"<?php echo $settings->Text_Align_In_Header->CellAttributes() ?>>
<span id="el_settings_Text_Align_In_Header" data-page="7">
<span<?php echo $settings->Text_Align_In_Header->ViewAttributes() ?>>
<?php echo $settings->Text_Align_In_Header->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Site_Title_Text_Style->Visible) { // Site_Title_Text_Style ?>
	<tr id="r_Site_Title_Text_Style">
		<td><span id="elh_settings_Site_Title_Text_Style"><?php echo $settings->Site_Title_Text_Style->FldCaption() ?></span></td>
		<td data-name="Site_Title_Text_Style"<?php echo $settings->Site_Title_Text_Style->CellAttributes() ?>>
<span id="el_settings_Site_Title_Text_Style" data-page="7">
<span<?php echo $settings->Site_Title_Text_Style->ViewAttributes() ?>>
<?php echo $settings->Site_Title_Text_Style->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Language_Selector_Visibility->Visible) { // Language_Selector_Visibility ?>
	<tr id="r_Language_Selector_Visibility">
		<td><span id="elh_settings_Language_Selector_Visibility"><?php echo $settings->Language_Selector_Visibility->FldCaption() ?></span></td>
		<td data-name="Language_Selector_Visibility"<?php echo $settings->Language_Selector_Visibility->CellAttributes() ?>>
<span id="el_settings_Language_Selector_Visibility" data-page="7">
<span<?php echo $settings->Language_Selector_Visibility->ViewAttributes() ?>>
<?php echo $settings->Language_Selector_Visibility->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Language_Selector_Align->Visible) { // Language_Selector_Align ?>
	<tr id="r_Language_Selector_Align">
		<td><span id="elh_settings_Language_Selector_Align"><?php echo $settings->Language_Selector_Align->FldCaption() ?></span></td>
		<td data-name="Language_Selector_Align"<?php echo $settings->Language_Selector_Align->CellAttributes() ?>>
<span id="el_settings_Language_Selector_Align" data-page="7">
<span<?php echo $settings->Language_Selector_Align->ViewAttributes() ?>>
<?php echo $settings->Language_Selector_Align->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("8") ?>" id="tab_settings8">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Show_Entire_Footer->Visible) { // Show_Entire_Footer ?>
	<tr id="r_Show_Entire_Footer">
		<td><span id="elh_settings_Show_Entire_Footer"><?php echo $settings->Show_Entire_Footer->FldCaption() ?></span></td>
		<td data-name="Show_Entire_Footer"<?php echo $settings->Show_Entire_Footer->CellAttributes() ?>>
<span id="el_settings_Show_Entire_Footer" data-page="8">
<span<?php echo $settings->Show_Entire_Footer->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Entire_Footer->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Entire_Footer->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Entire_Footer->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Text_In_Footer->Visible) { // Show_Text_In_Footer ?>
	<tr id="r_Show_Text_In_Footer">
		<td><span id="elh_settings_Show_Text_In_Footer"><?php echo $settings->Show_Text_In_Footer->FldCaption() ?></span></td>
		<td data-name="Show_Text_In_Footer"<?php echo $settings->Show_Text_In_Footer->CellAttributes() ?>>
<span id="el_settings_Show_Text_In_Footer" data-page="8">
<span<?php echo $settings->Show_Text_In_Footer->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Text_In_Footer->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Text_In_Footer->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Text_In_Footer->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Back_To_Top_On_Footer->Visible) { // Show_Back_To_Top_On_Footer ?>
	<tr id="r_Show_Back_To_Top_On_Footer">
		<td><span id="elh_settings_Show_Back_To_Top_On_Footer"><?php echo $settings->Show_Back_To_Top_On_Footer->FldCaption() ?></span></td>
		<td data-name="Show_Back_To_Top_On_Footer"<?php echo $settings->Show_Back_To_Top_On_Footer->CellAttributes() ?>>
<span id="el_settings_Show_Back_To_Top_On_Footer" data-page="8">
<span<?php echo $settings->Show_Back_To_Top_On_Footer->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Back_To_Top_On_Footer->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Back_To_Top_On_Footer->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Back_To_Top_On_Footer->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Terms_And_Conditions_On_Footer->Visible) { // Show_Terms_And_Conditions_On_Footer ?>
	<tr id="r_Show_Terms_And_Conditions_On_Footer">
		<td><span id="elh_settings_Show_Terms_And_Conditions_On_Footer"><?php echo $settings->Show_Terms_And_Conditions_On_Footer->FldCaption() ?></span></td>
		<td data-name="Show_Terms_And_Conditions_On_Footer"<?php echo $settings->Show_Terms_And_Conditions_On_Footer->CellAttributes() ?>>
<span id="el_settings_Show_Terms_And_Conditions_On_Footer" data-page="8">
<span<?php echo $settings->Show_Terms_And_Conditions_On_Footer->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Terms_And_Conditions_On_Footer->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Terms_And_Conditions_On_Footer->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Terms_And_Conditions_On_Footer->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_About_Us_On_Footer->Visible) { // Show_About_Us_On_Footer ?>
	<tr id="r_Show_About_Us_On_Footer">
		<td><span id="elh_settings_Show_About_Us_On_Footer"><?php echo $settings->Show_About_Us_On_Footer->FldCaption() ?></span></td>
		<td data-name="Show_About_Us_On_Footer"<?php echo $settings->Show_About_Us_On_Footer->CellAttributes() ?>>
<span id="el_settings_Show_About_Us_On_Footer" data-page="8">
<span<?php echo $settings->Show_About_Us_On_Footer->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_About_Us_On_Footer->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_About_Us_On_Footer->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_About_Us_On_Footer->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("9") ?>" id="tab_settings9">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Pagination_Position->Visible) { // Pagination_Position ?>
	<tr id="r_Pagination_Position">
		<td><span id="elh_settings_Pagination_Position"><?php echo $settings->Pagination_Position->FldCaption() ?></span></td>
		<td data-name="Pagination_Position"<?php echo $settings->Pagination_Position->CellAttributes() ?>>
<span id="el_settings_Pagination_Position" data-page="9">
<span<?php echo $settings->Pagination_Position->ViewAttributes() ?>>
<?php echo $settings->Pagination_Position->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Pagination_Style->Visible) { // Pagination_Style ?>
	<tr id="r_Pagination_Style">
		<td><span id="elh_settings_Pagination_Style"><?php echo $settings->Pagination_Style->FldCaption() ?></span></td>
		<td data-name="Pagination_Style"<?php echo $settings->Pagination_Style->CellAttributes() ?>>
<span id="el_settings_Pagination_Style" data-page="9">
<span<?php echo $settings->Pagination_Style->ViewAttributes() ?>>
<?php echo $settings->Pagination_Style->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Selectable_Records_Per_Page->Visible) { // Selectable_Records_Per_Page ?>
	<tr id="r_Selectable_Records_Per_Page">
		<td><span id="elh_settings_Selectable_Records_Per_Page"><?php echo $settings->Selectable_Records_Per_Page->FldCaption() ?></span></td>
		<td data-name="Selectable_Records_Per_Page"<?php echo $settings->Selectable_Records_Per_Page->CellAttributes() ?>>
<span id="el_settings_Selectable_Records_Per_Page" data-page="9">
<span<?php echo $settings->Selectable_Records_Per_Page->ViewAttributes() ?>>
<?php echo $settings->Selectable_Records_Per_Page->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Selectable_Groups_Per_Page->Visible) { // Selectable_Groups_Per_Page ?>
	<tr id="r_Selectable_Groups_Per_Page">
		<td><span id="elh_settings_Selectable_Groups_Per_Page"><?php echo $settings->Selectable_Groups_Per_Page->FldCaption() ?></span></td>
		<td data-name="Selectable_Groups_Per_Page"<?php echo $settings->Selectable_Groups_Per_Page->CellAttributes() ?>>
<span id="el_settings_Selectable_Groups_Per_Page" data-page="9">
<span<?php echo $settings->Selectable_Groups_Per_Page->ViewAttributes() ?>>
<?php echo $settings->Selectable_Groups_Per_Page->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Record_Per_Page->Visible) { // Default_Record_Per_Page ?>
	<tr id="r_Default_Record_Per_Page">
		<td><span id="elh_settings_Default_Record_Per_Page"><?php echo $settings->Default_Record_Per_Page->FldCaption() ?></span></td>
		<td data-name="Default_Record_Per_Page"<?php echo $settings->Default_Record_Per_Page->CellAttributes() ?>>
<span id="el_settings_Default_Record_Per_Page" data-page="9">
<span<?php echo $settings->Default_Record_Per_Page->ViewAttributes() ?>>
<?php echo $settings->Default_Record_Per_Page->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Default_Group_Per_Page->Visible) { // Default_Group_Per_Page ?>
	<tr id="r_Default_Group_Per_Page">
		<td><span id="elh_settings_Default_Group_Per_Page"><?php echo $settings->Default_Group_Per_Page->FldCaption() ?></span></td>
		<td data-name="Default_Group_Per_Page"<?php echo $settings->Default_Group_Per_Page->CellAttributes() ?>>
<span id="el_settings_Default_Group_Per_Page" data-page="9">
<span<?php echo $settings->Default_Group_Per_Page->ViewAttributes() ?>>
<?php echo $settings->Default_Group_Per_Page->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Maximum_Selected_Records->Visible) { // Maximum_Selected_Records ?>
	<tr id="r_Maximum_Selected_Records">
		<td><span id="elh_settings_Maximum_Selected_Records"><?php echo $settings->Maximum_Selected_Records->FldCaption() ?></span></td>
		<td data-name="Maximum_Selected_Records"<?php echo $settings->Maximum_Selected_Records->CellAttributes() ?>>
<span id="el_settings_Maximum_Selected_Records" data-page="9">
<span<?php echo $settings->Maximum_Selected_Records->ViewAttributes() ?>>
<?php echo $settings->Maximum_Selected_Records->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Maximum_Selected_Groups->Visible) { // Maximum_Selected_Groups ?>
	<tr id="r_Maximum_Selected_Groups">
		<td><span id="elh_settings_Maximum_Selected_Groups"><?php echo $settings->Maximum_Selected_Groups->FldCaption() ?></span></td>
		<td data-name="Maximum_Selected_Groups"<?php echo $settings->Maximum_Selected_Groups->CellAttributes() ?>>
<span id="el_settings_Maximum_Selected_Groups" data-page="9">
<span<?php echo $settings->Maximum_Selected_Groups->ViewAttributes() ?>>
<?php echo $settings->Maximum_Selected_Groups->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_PageNum_If_Record_Not_Over_Pagesize->Visible) { // Show_PageNum_If_Record_Not_Over_Pagesize ?>
	<tr id="r_Show_PageNum_If_Record_Not_Over_Pagesize">
		<td><span id="elh_settings_Show_PageNum_If_Record_Not_Over_Pagesize"><?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->FldCaption() ?></span></td>
		<td data-name="Show_PageNum_If_Record_Not_Over_Pagesize"<?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->CellAttributes() ?>>
<span id="el_settings_Show_PageNum_If_Record_Not_Over_Pagesize" data-page="9">
<span<?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_PageNum_If_Record_Not_Over_Pagesize->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("10") ?>" id="tab_settings10">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Table_Width_Style->Visible) { // Table_Width_Style ?>
	<tr id="r_Table_Width_Style">
		<td><span id="elh_settings_Table_Width_Style"><?php echo $settings->Table_Width_Style->FldCaption() ?></span></td>
		<td data-name="Table_Width_Style"<?php echo $settings->Table_Width_Style->CellAttributes() ?>>
<span id="el_settings_Table_Width_Style" data-page="10">
<span<?php echo $settings->Table_Width_Style->ViewAttributes() ?>>
<?php echo $settings->Table_Width_Style->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Scroll_Table_Width->Visible) { // Scroll_Table_Width ?>
	<tr id="r_Scroll_Table_Width">
		<td><span id="elh_settings_Scroll_Table_Width"><?php echo $settings->Scroll_Table_Width->FldCaption() ?></span></td>
		<td data-name="Scroll_Table_Width"<?php echo $settings->Scroll_Table_Width->CellAttributes() ?>>
<span id="el_settings_Scroll_Table_Width" data-page="10">
<span<?php echo $settings->Scroll_Table_Width->ViewAttributes() ?>>
<?php echo $settings->Scroll_Table_Width->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Scroll_Table_Height->Visible) { // Scroll_Table_Height ?>
	<tr id="r_Scroll_Table_Height">
		<td><span id="elh_settings_Scroll_Table_Height"><?php echo $settings->Scroll_Table_Height->FldCaption() ?></span></td>
		<td data-name="Scroll_Table_Height"<?php echo $settings->Scroll_Table_Height->CellAttributes() ?>>
<span id="el_settings_Scroll_Table_Height" data-page="10">
<span<?php echo $settings->Scroll_Table_Height->ViewAttributes() ?>>
<?php echo $settings->Scroll_Table_Height->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Search_Panel_Collapsed->Visible) { // Search_Panel_Collapsed ?>
	<tr id="r_Search_Panel_Collapsed">
		<td><span id="elh_settings_Search_Panel_Collapsed"><?php echo $settings->Search_Panel_Collapsed->FldCaption() ?></span></td>
		<td data-name="Search_Panel_Collapsed"<?php echo $settings->Search_Panel_Collapsed->CellAttributes() ?>>
<span id="el_settings_Search_Panel_Collapsed" data-page="10">
<span<?php echo $settings->Search_Panel_Collapsed->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Search_Panel_Collapsed->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Search_Panel_Collapsed->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Search_Panel_Collapsed->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Filter_Panel_Collapsed->Visible) { // Filter_Panel_Collapsed ?>
	<tr id="r_Filter_Panel_Collapsed">
		<td><span id="elh_settings_Filter_Panel_Collapsed"><?php echo $settings->Filter_Panel_Collapsed->FldCaption() ?></span></td>
		<td data-name="Filter_Panel_Collapsed"<?php echo $settings->Filter_Panel_Collapsed->CellAttributes() ?>>
<span id="el_settings_Filter_Panel_Collapsed" data-page="10">
<span<?php echo $settings->Filter_Panel_Collapsed->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Filter_Panel_Collapsed->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Filter_Panel_Collapsed->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Filter_Panel_Collapsed->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Record_Number_On_List_Page->Visible) { // Show_Record_Number_On_List_Page ?>
	<tr id="r_Show_Record_Number_On_List_Page">
		<td><span id="elh_settings_Show_Record_Number_On_List_Page"><?php echo $settings->Show_Record_Number_On_List_Page->FldCaption() ?></span></td>
		<td data-name="Show_Record_Number_On_List_Page"<?php echo $settings->Show_Record_Number_On_List_Page->CellAttributes() ?>>
<span id="el_settings_Show_Record_Number_On_List_Page" data-page="10">
<span<?php echo $settings->Show_Record_Number_On_List_Page->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Record_Number_On_List_Page->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Record_Number_On_List_Page->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Record_Number_On_List_Page->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Empty_Table_On_List_Page->Visible) { // Show_Empty_Table_On_List_Page ?>
	<tr id="r_Show_Empty_Table_On_List_Page">
		<td><span id="elh_settings_Show_Empty_Table_On_List_Page"><?php echo $settings->Show_Empty_Table_On_List_Page->FldCaption() ?></span></td>
		<td data-name="Show_Empty_Table_On_List_Page"<?php echo $settings->Show_Empty_Table_On_List_Page->CellAttributes() ?>>
<span id="el_settings_Show_Empty_Table_On_List_Page" data-page="10">
<span<?php echo $settings->Show_Empty_Table_On_List_Page->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Empty_Table_On_List_Page->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Empty_Table_On_List_Page->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Empty_Table_On_List_Page->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Rows_Vertical_Align_Top->Visible) { // Rows_Vertical_Align_Top ?>
	<tr id="r_Rows_Vertical_Align_Top">
		<td><span id="elh_settings_Rows_Vertical_Align_Top"><?php echo $settings->Rows_Vertical_Align_Top->FldCaption() ?></span></td>
		<td data-name="Rows_Vertical_Align_Top"<?php echo $settings->Rows_Vertical_Align_Top->CellAttributes() ?>>
<span id="el_settings_Rows_Vertical_Align_Top" data-page="10">
<span<?php echo $settings->Rows_Vertical_Align_Top->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Rows_Vertical_Align_Top->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Rows_Vertical_Align_Top->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Rows_Vertical_Align_Top->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Action_Button_Alignment->Visible) { // Action_Button_Alignment ?>
	<tr id="r_Action_Button_Alignment">
		<td><span id="elh_settings_Action_Button_Alignment"><?php echo $settings->Action_Button_Alignment->FldCaption() ?></span></td>
		<td data-name="Action_Button_Alignment"<?php echo $settings->Action_Button_Alignment->CellAttributes() ?>>
<span id="el_settings_Action_Button_Alignment" data-page="10">
<span<?php echo $settings->Action_Button_Alignment->ViewAttributes() ?>>
<?php echo $settings->Action_Button_Alignment->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("11") ?>" id="tab_settings11">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Show_Add_Success_Message->Visible) { // Show_Add_Success_Message ?>
	<tr id="r_Show_Add_Success_Message">
		<td><span id="elh_settings_Show_Add_Success_Message"><?php echo $settings->Show_Add_Success_Message->FldCaption() ?></span></td>
		<td data-name="Show_Add_Success_Message"<?php echo $settings->Show_Add_Success_Message->CellAttributes() ?>>
<span id="el_settings_Show_Add_Success_Message" data-page="11">
<span<?php echo $settings->Show_Add_Success_Message->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Add_Success_Message->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Add_Success_Message->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Add_Success_Message->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Edit_Success_Message->Visible) { // Show_Edit_Success_Message ?>
	<tr id="r_Show_Edit_Success_Message">
		<td><span id="elh_settings_Show_Edit_Success_Message"><?php echo $settings->Show_Edit_Success_Message->FldCaption() ?></span></td>
		<td data-name="Show_Edit_Success_Message"<?php echo $settings->Show_Edit_Success_Message->CellAttributes() ?>>
<span id="el_settings_Show_Edit_Success_Message" data-page="11">
<span<?php echo $settings->Show_Edit_Success_Message->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Edit_Success_Message->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Edit_Success_Message->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Edit_Success_Message->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->jQuery_Auto_Hide_Success_Message->Visible) { // jQuery_Auto_Hide_Success_Message ?>
	<tr id="r_jQuery_Auto_Hide_Success_Message">
		<td><span id="elh_settings_jQuery_Auto_Hide_Success_Message"><?php echo $settings->jQuery_Auto_Hide_Success_Message->FldCaption() ?></span></td>
		<td data-name="jQuery_Auto_Hide_Success_Message"<?php echo $settings->jQuery_Auto_Hide_Success_Message->CellAttributes() ?>>
<span id="el_settings_jQuery_Auto_Hide_Success_Message" data-page="11">
<span<?php echo $settings->jQuery_Auto_Hide_Success_Message->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->jQuery_Auto_Hide_Success_Message->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->jQuery_Auto_Hide_Success_Message->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->jQuery_Auto_Hide_Success_Message->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Use_Javascript_Message->Visible) { // Use_Javascript_Message ?>
	<tr id="r_Use_Javascript_Message">
		<td><span id="elh_settings_Use_Javascript_Message"><?php echo $settings->Use_Javascript_Message->FldCaption() ?></span></td>
		<td data-name="Use_Javascript_Message"<?php echo $settings->Use_Javascript_Message->CellAttributes() ?>>
<span id="el_settings_Use_Javascript_Message" data-page="11">
<span<?php echo $settings->Use_Javascript_Message->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Use_Javascript_Message->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Use_Javascript_Message->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Use_Javascript_Message->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Login_Window_Type->Visible) { // Login_Window_Type ?>
	<tr id="r_Login_Window_Type">
		<td><span id="elh_settings_Login_Window_Type"><?php echo $settings->Login_Window_Type->FldCaption() ?></span></td>
		<td data-name="Login_Window_Type"<?php echo $settings->Login_Window_Type->CellAttributes() ?>>
<span id="el_settings_Login_Window_Type" data-page="11">
<span<?php echo $settings->Login_Window_Type->ViewAttributes() ?>>
<?php echo $settings->Login_Window_Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Forgot_Password_Window_Type->Visible) { // Forgot_Password_Window_Type ?>
	<tr id="r_Forgot_Password_Window_Type">
		<td><span id="elh_settings_Forgot_Password_Window_Type"><?php echo $settings->Forgot_Password_Window_Type->FldCaption() ?></span></td>
		<td data-name="Forgot_Password_Window_Type"<?php echo $settings->Forgot_Password_Window_Type->CellAttributes() ?>>
<span id="el_settings_Forgot_Password_Window_Type" data-page="11">
<span<?php echo $settings->Forgot_Password_Window_Type->ViewAttributes() ?>>
<?php echo $settings->Forgot_Password_Window_Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Change_Password_Window_Type->Visible) { // Change_Password_Window_Type ?>
	<tr id="r_Change_Password_Window_Type">
		<td><span id="elh_settings_Change_Password_Window_Type"><?php echo $settings->Change_Password_Window_Type->FldCaption() ?></span></td>
		<td data-name="Change_Password_Window_Type"<?php echo $settings->Change_Password_Window_Type->CellAttributes() ?>>
<span id="el_settings_Change_Password_Window_Type" data-page="11">
<span<?php echo $settings->Change_Password_Window_Type->ViewAttributes() ?>>
<?php echo $settings->Change_Password_Window_Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Registration_Window_Type->Visible) { // Registration_Window_Type ?>
	<tr id="r_Registration_Window_Type">
		<td><span id="elh_settings_Registration_Window_Type"><?php echo $settings->Registration_Window_Type->FldCaption() ?></span></td>
		<td data-name="Registration_Window_Type"<?php echo $settings->Registration_Window_Type->CellAttributes() ?>>
<span id="el_settings_Registration_Window_Type" data-page="11">
<span<?php echo $settings->Registration_Window_Type->ViewAttributes() ?>>
<?php echo $settings->Registration_Window_Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("12") ?>" id="tab_settings12">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Show_Record_Number_On_Detail_Preview->Visible) { // Show_Record_Number_On_Detail_Preview ?>
	<tr id="r_Show_Record_Number_On_Detail_Preview">
		<td><span id="elh_settings_Show_Record_Number_On_Detail_Preview"><?php echo $settings->Show_Record_Number_On_Detail_Preview->FldCaption() ?></span></td>
		<td data-name="Show_Record_Number_On_Detail_Preview"<?php echo $settings->Show_Record_Number_On_Detail_Preview->CellAttributes() ?>>
<span id="el_settings_Show_Record_Number_On_Detail_Preview" data-page="12">
<span<?php echo $settings->Show_Record_Number_On_Detail_Preview->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Record_Number_On_Detail_Preview->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Record_Number_On_Detail_Preview->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Record_Number_On_Detail_Preview->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Empty_Table_In_Detail_Preview->Visible) { // Show_Empty_Table_In_Detail_Preview ?>
	<tr id="r_Show_Empty_Table_In_Detail_Preview">
		<td><span id="elh_settings_Show_Empty_Table_In_Detail_Preview"><?php echo $settings->Show_Empty_Table_In_Detail_Preview->FldCaption() ?></span></td>
		<td data-name="Show_Empty_Table_In_Detail_Preview"<?php echo $settings->Show_Empty_Table_In_Detail_Preview->CellAttributes() ?>>
<span id="el_settings_Show_Empty_Table_In_Detail_Preview" data-page="12">
<span<?php echo $settings->Show_Empty_Table_In_Detail_Preview->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Empty_Table_In_Detail_Preview->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Empty_Table_In_Detail_Preview->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Empty_Table_In_Detail_Preview->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Detail_Preview_Table_Width->Visible) { // Detail_Preview_Table_Width ?>
	<tr id="r_Detail_Preview_Table_Width">
		<td><span id="elh_settings_Detail_Preview_Table_Width"><?php echo $settings->Detail_Preview_Table_Width->FldCaption() ?></span></td>
		<td data-name="Detail_Preview_Table_Width"<?php echo $settings->Detail_Preview_Table_Width->CellAttributes() ?>>
<span id="el_settings_Detail_Preview_Table_Width" data-page="12">
<span<?php echo $settings->Detail_Preview_Table_Width->ViewAttributes() ?>>
<?php echo $settings->Detail_Preview_Table_Width->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("13") ?>" id="tab_settings13">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Password_Minimum_Length->Visible) { // Password_Minimum_Length ?>
	<tr id="r_Password_Minimum_Length">
		<td><span id="elh_settings_Password_Minimum_Length"><?php echo $settings->Password_Minimum_Length->FldCaption() ?></span></td>
		<td data-name="Password_Minimum_Length"<?php echo $settings->Password_Minimum_Length->CellAttributes() ?>>
<span id="el_settings_Password_Minimum_Length" data-page="13">
<span<?php echo $settings->Password_Minimum_Length->ViewAttributes() ?>>
<?php echo $settings->Password_Minimum_Length->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Maximum_Length->Visible) { // Password_Maximum_Length ?>
	<tr id="r_Password_Maximum_Length">
		<td><span id="elh_settings_Password_Maximum_Length"><?php echo $settings->Password_Maximum_Length->FldCaption() ?></span></td>
		<td data-name="Password_Maximum_Length"<?php echo $settings->Password_Maximum_Length->CellAttributes() ?>>
<span id="el_settings_Password_Maximum_Length" data-page="13">
<span<?php echo $settings->Password_Maximum_Length->ViewAttributes() ?>>
<?php echo $settings->Password_Maximum_Length->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Must_Contain_At_Least_One_Lower_Case->Visible) { // Password_Must_Contain_At_Least_One_Lower_Case ?>
	<tr id="r_Password_Must_Contain_At_Least_One_Lower_Case">
		<td><span id="elh_settings_Password_Must_Contain_At_Least_One_Lower_Case"><?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->FldCaption() ?></span></td>
		<td data-name="Password_Must_Contain_At_Least_One_Lower_Case"<?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->CellAttributes() ?>>
<span id="el_settings_Password_Must_Contain_At_Least_One_Lower_Case" data-page="13">
<span<?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Password_Must_Contain_At_Least_One_Lower_Case->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Must_Comply_With_Minumum_Length->Visible) { // Password_Must_Comply_With_Minumum_Length ?>
	<tr id="r_Password_Must_Comply_With_Minumum_Length">
		<td><span id="elh_settings_Password_Must_Comply_With_Minumum_Length"><?php echo $settings->Password_Must_Comply_With_Minumum_Length->FldCaption() ?></span></td>
		<td data-name="Password_Must_Comply_With_Minumum_Length"<?php echo $settings->Password_Must_Comply_With_Minumum_Length->CellAttributes() ?>>
<span id="el_settings_Password_Must_Comply_With_Minumum_Length" data-page="13">
<span<?php echo $settings->Password_Must_Comply_With_Minumum_Length->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Password_Must_Comply_With_Minumum_Length->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Comply_With_Minumum_Length->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Comply_With_Minumum_Length->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Must_Comply_With_Maximum_Length->Visible) { // Password_Must_Comply_With_Maximum_Length ?>
	<tr id="r_Password_Must_Comply_With_Maximum_Length">
		<td><span id="elh_settings_Password_Must_Comply_With_Maximum_Length"><?php echo $settings->Password_Must_Comply_With_Maximum_Length->FldCaption() ?></span></td>
		<td data-name="Password_Must_Comply_With_Maximum_Length"<?php echo $settings->Password_Must_Comply_With_Maximum_Length->CellAttributes() ?>>
<span id="el_settings_Password_Must_Comply_With_Maximum_Length" data-page="13">
<span<?php echo $settings->Password_Must_Comply_With_Maximum_Length->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Password_Must_Comply_With_Maximum_Length->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Comply_With_Maximum_Length->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Comply_With_Maximum_Length->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Must_Contain_At_Least_One_Upper_Case->Visible) { // Password_Must_Contain_At_Least_One_Upper_Case ?>
	<tr id="r_Password_Must_Contain_At_Least_One_Upper_Case">
		<td><span id="elh_settings_Password_Must_Contain_At_Least_One_Upper_Case"><?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->FldCaption() ?></span></td>
		<td data-name="Password_Must_Contain_At_Least_One_Upper_Case"<?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->CellAttributes() ?>>
<span id="el_settings_Password_Must_Contain_At_Least_One_Upper_Case" data-page="13">
<span<?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Password_Must_Contain_At_Least_One_Upper_Case->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Must_Contain_At_Least_One_Numeric->Visible) { // Password_Must_Contain_At_Least_One_Numeric ?>
	<tr id="r_Password_Must_Contain_At_Least_One_Numeric">
		<td><span id="elh_settings_Password_Must_Contain_At_Least_One_Numeric"><?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->FldCaption() ?></span></td>
		<td data-name="Password_Must_Contain_At_Least_One_Numeric"<?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->CellAttributes() ?>>
<span id="el_settings_Password_Must_Contain_At_Least_One_Numeric" data-page="13">
<span<?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Password_Must_Contain_At_Least_One_Numeric->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Must_Contain_At_Least_One_Symbol->Visible) { // Password_Must_Contain_At_Least_One_Symbol ?>
	<tr id="r_Password_Must_Contain_At_Least_One_Symbol">
		<td><span id="elh_settings_Password_Must_Contain_At_Least_One_Symbol"><?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->FldCaption() ?></span></td>
		<td data-name="Password_Must_Contain_At_Least_One_Symbol"<?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->CellAttributes() ?>>
<span id="el_settings_Password_Must_Contain_At_Least_One_Symbol" data-page="13">
<span<?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Password_Must_Contain_At_Least_One_Symbol->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Password_Must_Be_Difference_Between_Old_And_New->Visible) { // Password_Must_Be_Difference_Between_Old_And_New ?>
	<tr id="r_Password_Must_Be_Difference_Between_Old_And_New">
		<td><span id="elh_settings_Password_Must_Be_Difference_Between_Old_And_New"><?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->FldCaption() ?></span></td>
		<td data-name="Password_Must_Be_Difference_Between_Old_And_New"<?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->CellAttributes() ?>>
<span id="el_settings_Password_Must_Be_Difference_Between_Old_And_New" data-page="13">
<span<?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Password_Must_Be_Difference_Between_Old_And_New->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Reset_Password_Field_Options->Visible) { // Reset_Password_Field_Options ?>
	<tr id="r_Reset_Password_Field_Options">
		<td><span id="elh_settings_Reset_Password_Field_Options"><?php echo $settings->Reset_Password_Field_Options->FldCaption() ?></span></td>
		<td data-name="Reset_Password_Field_Options"<?php echo $settings->Reset_Password_Field_Options->CellAttributes() ?>>
<span id="el_settings_Reset_Password_Field_Options" data-page="13">
<span<?php echo $settings->Reset_Password_Field_Options->ViewAttributes() ?>>
<?php echo $settings->Reset_Password_Field_Options->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
		<div class="tab-pane<?php echo $settings_view->MultiPages->PageStyle("14") ?>" id="tab_settings14">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($settings->Export_Record_Options->Visible) { // Export_Record_Options ?>
	<tr id="r_Export_Record_Options">
		<td><span id="elh_settings_Export_Record_Options"><?php echo $settings->Export_Record_Options->FldCaption() ?></span></td>
		<td data-name="Export_Record_Options"<?php echo $settings->Export_Record_Options->CellAttributes() ?>>
<span id="el_settings_Export_Record_Options" data-page="14">
<span<?php echo $settings->Export_Record_Options->ViewAttributes() ?>>
<?php echo $settings->Export_Record_Options->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Show_Record_Number_On_Exported_List_Page->Visible) { // Show_Record_Number_On_Exported_List_Page ?>
	<tr id="r_Show_Record_Number_On_Exported_List_Page">
		<td><span id="elh_settings_Show_Record_Number_On_Exported_List_Page"><?php echo $settings->Show_Record_Number_On_Exported_List_Page->FldCaption() ?></span></td>
		<td data-name="Show_Record_Number_On_Exported_List_Page"<?php echo $settings->Show_Record_Number_On_Exported_List_Page->CellAttributes() ?>>
<span id="el_settings_Show_Record_Number_On_Exported_List_Page" data-page="14">
<span<?php echo $settings->Show_Record_Number_On_Exported_List_Page->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Show_Record_Number_On_Exported_List_Page->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Show_Record_Number_On_Exported_List_Page->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Show_Record_Number_On_Exported_List_Page->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Use_Table_Setting_For_Export_Field_Caption->Visible) { // Use_Table_Setting_For_Export_Field_Caption ?>
	<tr id="r_Use_Table_Setting_For_Export_Field_Caption">
		<td><span id="elh_settings_Use_Table_Setting_For_Export_Field_Caption"><?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->FldCaption() ?></span></td>
		<td data-name="Use_Table_Setting_For_Export_Field_Caption"<?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->CellAttributes() ?>>
<span id="el_settings_Use_Table_Setting_For_Export_Field_Caption" data-page="14">
<span<?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Use_Table_Setting_For_Export_Field_Caption->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($settings->Use_Table_Setting_For_Export_Original_Value->Visible) { // Use_Table_Setting_For_Export_Original_Value ?>
	<tr id="r_Use_Table_Setting_For_Export_Original_Value">
		<td><span id="elh_settings_Use_Table_Setting_For_Export_Original_Value"><?php echo $settings->Use_Table_Setting_For_Export_Original_Value->FldCaption() ?></span></td>
		<td data-name="Use_Table_Setting_For_Export_Original_Value"<?php echo $settings->Use_Table_Setting_For_Export_Original_Value->CellAttributes() ?>>
<span id="el_settings_Use_Table_Setting_For_Export_Original_Value" data-page="14">
<span<?php echo $settings->Use_Table_Setting_For_Export_Original_Value->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($settings->Use_Table_Setting_For_Export_Original_Value->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $settings->Use_Table_Setting_For_Export_Original_Value->ViewValue ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $settings->Use_Table_Setting_For_Export_Original_Value->ViewValue ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($settings->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($settings->Export == "") { ?>
	</div>
</div>
</div>
<?php } ?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
<?php if ($settings->Export == "") { ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($settings_view->Pager)) $settings_view->Pager = new cNumericPager($settings_view->StartRec, $settings_view->DisplayRecs, $settings_view->TotalRecs, $settings_view->RecRange) ?>
		<?php if ($settings_view->Pager->RecordCount > 0) { ?>
				<?php if (($settings_view->Pager->PageCount==1) && ($settings_view->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $settings_view->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $settings_view->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $settings_view->Pager->RecordCount ?></span>
				</div>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($settings_view->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_view->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($settings_view->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $settings_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($settings_view->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_view->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($settings_view->Pager)) $settings_view->Pager = new cPrevNextPager($settings_view->StartRec, $settings_view->DisplayRecs, $settings_view->TotalRecs) ?>
		<?php if ($settings_view->Pager->RecordCount > 0) { ?>
				<?php if (($settings_view->Pager->PageCount==1) && ($settings_view->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
						<div class="ewPager ewRec">
							<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $settings_view->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $settings_view->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $settings_view->Pager->RecordCount ?></span>
						</div>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($settings_view->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($settings_view->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $settings_view->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($settings_view->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($settings_view->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_view->PageUrl() ?>start=<?php echo $settings_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $settings_view->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
</form>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">
fsettingsview.Init();
</script>
<?php } ?>
<?php
$settings_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">
$('a.ewDelete').attr('onclick', 'return alertifyDeleteFromView(this)'); function alertifyDeleteFromView(obj) { <?php global $Language; ?> alertify.confirm("<?php echo $Language->Phrase('AlertifyDeleteConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyProcessing'); ?>"); window.location = obj.href; } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$settings_view->Page_Terminate();
?>
