<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "a_suppliersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "a_purchasesgridcls.php" ?>
<?php include_once "a_stock_itemsgridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_suppliers_view = NULL; // Initialize page object first

class ca_suppliers_view extends ca_suppliers {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_suppliers';

	// Page object name
	var $PageObjName = 'a_suppliers_view';

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

		// Table object (a_suppliers)
		if (!isset($GLOBALS["a_suppliers"]) || get_class($GLOBALS["a_suppliers"]) == "ca_suppliers") {
			$GLOBALS["a_suppliers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["a_suppliers"];
		}
		$KeyUrl = "";
		if (@$_GET["Supplier_ID"] <> "") {
			$this->RecKey["Supplier_ID"] = $_GET["Supplier_ID"];
			$KeyUrl .= "&amp;Supplier_ID=" . urlencode($this->RecKey["Supplier_ID"]);
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
		if (!$Security->CanView()) {
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
		if (@$_GET["Supplier_ID"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["Supplier_ID"]);
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
	var $a_purchases_Count;
	var $a_stock_items_Count;
	var $Recordset;

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
			if (@$_GET["Supplier_ID"] <> "") {
				$this->Supplier_ID->setQueryStringValue($_GET["Supplier_ID"]);
				$this->RecKey["Supplier_ID"] = $this->Supplier_ID->QueryStringValue;

			// Begin of changes v11.0.6
			} elseif (@$_POST["Supplier_ID"] <> "") {
				$this->Supplier_ID->setFormValue($_POST["Supplier_ID"]);
				$this->RecKey["Supplier_ID"] = $this->Supplier_ID->FormValue;

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
						$this->Page_Terminate("a_supplierslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->Supplier_ID->CurrentValue) == strval($this->Recordset->fields('Supplier_ID'))) {
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
						$sReturnUrl = "a_supplierslist.php"; // No matching record, return to list
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
			$sReturnUrl = "a_supplierslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetUpDetailParms();
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
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_a_purchases"
		$item = &$option->Add("detail_a_purchases");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("a_purchases", "TblCaption");

		//$body .= str_replace("%c", $this->a_purchases_Count, $Language->Phrase("DetailCount"));
		if ( $this->a_purchases_Count > 0 && MS_SHOW_DETAILCOUNT_GREATER_THAN_ZERO_ONLY == TRUE ) {
			if (MS_USE_BADGE_FOR_DETAILCOUNT) {
				$body .= str_replace("(%c)", "", $Language->Phrase("DetailCount")); // added by Masino Sinaga, March 15, 2015
				$body .= "&nbsp; <span class='badge'>".$this->a_purchases_Count."</span>"; 
			} else {
				$body .= "&nbsp;" . str_replace("%c", $this->a_purchases_Count, $Language->Phrase("DetailCount"));
			}
		} elseif ( $this->a_purchases_Count >= 0 && MS_SHOW_DETAILCOUNT_GREATER_THAN_ZERO_ONLY == FALSE ) {
			if (MS_USE_BADGE_FOR_DETAILCOUNT) {
				$body .= str_replace("(%c)", "", $Language->Phrase("DetailCount")); // added by Masino Sinaga, March 15, 2015
				$body .= "&nbsp; <span class='badge'>".$this->a_purchases_Count."</span>"; 
			} else {
				$body .= "&nbsp;" . str_replace("%c", $this->a_purchases_Count, $Language->Phrase("DetailCount"));
			}
		}
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("a_purchaseslist.php?" . EW_TABLE_SHOW_MASTER . "=a_suppliers&fk_Supplier_Number=" . urlencode(strval($this->Supplier_Number->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["a_purchases_grid"] && $GLOBALS["a_purchases_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'a_purchases')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=a_purchases")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "a_purchases";
		}
		if ($GLOBALS["a_purchases_grid"] && $GLOBALS["a_purchases_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'a_purchases')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=a_purchases")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "a_purchases";
		}
		if ($GLOBALS["a_purchases_grid"] && $GLOBALS["a_purchases_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'a_purchases')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=a_purchases")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "a_purchases";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'a_purchases');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "a_purchases";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_a_stock_items"
		$item = &$option->Add("detail_a_stock_items");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("a_stock_items", "TblCaption");

		//$body .= str_replace("%c", $this->a_stock_items_Count, $Language->Phrase("DetailCount"));
		if ( $this->a_stock_items_Count > 0 && MS_SHOW_DETAILCOUNT_GREATER_THAN_ZERO_ONLY == TRUE ) {
			if (MS_USE_BADGE_FOR_DETAILCOUNT) {
				$body .= str_replace("(%c)", "", $Language->Phrase("DetailCount")); // added by Masino Sinaga, March 15, 2015
				$body .= "&nbsp; <span class='badge'>".$this->a_stock_items_Count."</span>"; 
			} else {
				$body .= "&nbsp;" . str_replace("%c", $this->a_stock_items_Count, $Language->Phrase("DetailCount"));
			}
		} elseif ( $this->a_stock_items_Count >= 0 && MS_SHOW_DETAILCOUNT_GREATER_THAN_ZERO_ONLY == FALSE ) {
			if (MS_USE_BADGE_FOR_DETAILCOUNT) {
				$body .= str_replace("(%c)", "", $Language->Phrase("DetailCount")); // added by Masino Sinaga, March 15, 2015
				$body .= "&nbsp; <span class='badge'>".$this->a_stock_items_Count."</span>"; 
			} else {
				$body .= "&nbsp;" . str_replace("%c", $this->a_stock_items_Count, $Language->Phrase("DetailCount"));
			}
		}
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("a_stock_itemslist.php?" . EW_TABLE_SHOW_MASTER . "=a_suppliers&fk_Supplier_Number=" . urlencode(strval($this->Supplier_Number->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["a_stock_items_grid"] && $GLOBALS["a_stock_items_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'a_stock_items')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=a_stock_items")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "a_stock_items";
		}
		if ($GLOBALS["a_stock_items_grid"] && $GLOBALS["a_stock_items_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'a_stock_items')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=a_stock_items")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "a_stock_items";
		}
		if ($GLOBALS["a_stock_items_grid"] && $GLOBALS["a_stock_items_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'a_stock_items')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=a_stock_items")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "a_stock_items";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'a_stock_items');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "a_stock_items";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

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
		$this->Supplier_ID->setDbValue($rs->fields('Supplier_ID'));
		$this->Supplier_Number->setDbValue($rs->fields('Supplier_Number'));
		$this->Supplier_Name->setDbValue($rs->fields('Supplier_Name'));
		$this->Address->setDbValue($rs->fields('Address'));
		$this->City->setDbValue($rs->fields('City'));
		$this->Country->setDbValue($rs->fields('Country'));
		$this->Contact_Person->setDbValue($rs->fields('Contact_Person'));
		$this->Phone_Number->setDbValue($rs->fields('Phone_Number'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Mobile_Number->setDbValue($rs->fields('Mobile_Number'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->Balance->setDbValue($rs->fields('Balance'));
		$this->Is_Stock_Available->setDbValue($rs->fields('Is_Stock_Available'));
		$this->Date_Added->setDbValue($rs->fields('Date_Added'));
		$this->Added_By->setDbValue($rs->fields('Added_By'));
		$this->Date_Updated->setDbValue($rs->fields('Date_Updated'));
		$this->Updated_By->setDbValue($rs->fields('Updated_By'));
		if (!isset($GLOBALS["a_purchases_grid"])) $GLOBALS["a_purchases_grid"] = new ca_purchases_grid;
		$sDetailFilter = $GLOBALS["a_purchases"]->SqlDetailFilter_a_suppliers();
		$sDetailFilter = str_replace("@Supplier_ID@", ew_AdjustSql($this->Supplier_Number->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["a_purchases"]->setCurrentMasterTable("a_suppliers");
		$sDetailFilter = $GLOBALS["a_purchases"]->ApplyUserIDFilters($sDetailFilter);
		$this->a_purchases_Count = $GLOBALS["a_purchases"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["a_stock_items_grid"])) $GLOBALS["a_stock_items_grid"] = new ca_stock_items_grid;
		$sDetailFilter = $GLOBALS["a_stock_items"]->SqlDetailFilter_a_suppliers();
		$sDetailFilter = str_replace("@Supplier_Number@", ew_AdjustSql($this->Supplier_Number->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["a_stock_items"]->setCurrentMasterTable("a_suppliers");
		$sDetailFilter = $GLOBALS["a_stock_items"]->ApplyUserIDFilters($sDetailFilter);
		$this->a_stock_items_Count = $GLOBALS["a_stock_items"]->LoadRecordCount($sDetailFilter);
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Supplier_ID->DbValue = $row['Supplier_ID'];
		$this->Supplier_Number->DbValue = $row['Supplier_Number'];
		$this->Supplier_Name->DbValue = $row['Supplier_Name'];
		$this->Address->DbValue = $row['Address'];
		$this->City->DbValue = $row['City'];
		$this->Country->DbValue = $row['Country'];
		$this->Contact_Person->DbValue = $row['Contact_Person'];
		$this->Phone_Number->DbValue = $row['Phone_Number'];
		$this->_Email->DbValue = $row['Email'];
		$this->Mobile_Number->DbValue = $row['Mobile_Number'];
		$this->Notes->DbValue = $row['Notes'];
		$this->Balance->DbValue = $row['Balance'];
		$this->Is_Stock_Available->DbValue = $row['Is_Stock_Available'];
		$this->Date_Added->DbValue = $row['Date_Added'];
		$this->Added_By->DbValue = $row['Added_By'];
		$this->Date_Updated->DbValue = $row['Date_Updated'];
		$this->Updated_By->DbValue = $row['Updated_By'];
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
        global $Language, $Security, $a_suppliers; // <-- Added $Security variable by Masino Sinaga

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
			$item->Body = "<button id=\"emf_a_suppliers\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_a_suppliers',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fa_suppliersview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export detail records (a_purchases)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("a_purchases", explode(",", $this->getCurrentDetailTable()))) {
			global $a_purchases;
			if (!isset($a_purchases)) $a_purchases = new ca_purchases;
			$rsdetail = $a_purchases->LoadRs($a_purchases->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$a_purchases->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}

		// Export detail records (a_stock_items)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("a_stock_items", explode(",", $this->getCurrentDetailTable()))) {
			global $a_stock_items;
			if (!isset($a_stock_items)) $a_stock_items = new ca_stock_items;
			$rsdetail = $a_stock_items->LoadRs($a_stock_items->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$a_stock_items->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}
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
			if (in_array("a_purchases", $DetailTblVar)) {
				if (!isset($GLOBALS["a_purchases_grid"]))
					$GLOBALS["a_purchases_grid"] = new ca_purchases_grid;
				if ($GLOBALS["a_purchases_grid"]->DetailView) {
					$GLOBALS["a_purchases_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["a_purchases_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["a_purchases_grid"]->setStartRecordNumber(1);
					$GLOBALS["a_purchases_grid"]->Supplier_ID->FldIsDetailKey = TRUE;
					$GLOBALS["a_purchases_grid"]->Supplier_ID->CurrentValue = $this->Supplier_Number->CurrentValue;
					$GLOBALS["a_purchases_grid"]->Supplier_ID->setSessionValue($GLOBALS["a_purchases_grid"]->Supplier_ID->CurrentValue);
				}
			}
			if (in_array("a_stock_items", $DetailTblVar)) {
				if (!isset($GLOBALS["a_stock_items_grid"]))
					$GLOBALS["a_stock_items_grid"] = new ca_stock_items_grid;
				if ($GLOBALS["a_stock_items_grid"]->DetailView) {
					$GLOBALS["a_stock_items_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["a_stock_items_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["a_stock_items_grid"]->setStartRecordNumber(1);
					$GLOBALS["a_stock_items_grid"]->Supplier_Number->FldIsDetailKey = TRUE;
					$GLOBALS["a_stock_items_grid"]->Supplier_Number->CurrentValue = $this->Supplier_Number->CurrentValue;
					$GLOBALS["a_stock_items_grid"]->Supplier_Number->setSessionValue($GLOBALS["a_stock_items_grid"]->Supplier_Number->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_supplierslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url); // v11.0.4
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
if (!isset($a_suppliers_view)) $a_suppliers_view = new ca_suppliers_view();

// Page init
$a_suppliers_view->Page_Init();

// Page main
$a_suppliers_view->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_suppliers_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($a_suppliers->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fa_suppliersview = new ew_Form("fa_suppliersview", "view");

// Form_CustomValidate event
fa_suppliersview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_suppliersview.ValidateRequired = true;
<?php } else { ?>
fa_suppliersview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_suppliersview.Lists["x_Is_Stock_Available"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_suppliersview.Lists["x_Is_Stock_Available"].Options = <?php echo json_encode($a_suppliers->Is_Stock_Available->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($a_suppliers->Export == "") { ?>
<div class="ewToolbar">
<?php if ($a_suppliers->Export == "") { ?>
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php } ?>
<?php $a_suppliers_view->ExportOptions->Render("body") ?>
<?php
	foreach ($a_suppliers_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($a_suppliers->Export == "") { ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $a_suppliers_view->ShowPageHeader(); ?>
<?php
$a_suppliers_view->ShowMessage();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<?php if ($a_suppliers->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($a_suppliers_view->Pager)) $a_suppliers_view->Pager = new cNumericPager($a_suppliers_view->StartRec, $a_suppliers_view->DisplayRecs, $a_suppliers_view->TotalRecs, $a_suppliers_view->RecRange) ?>
		<?php if ($a_suppliers_view->Pager->RecordCount > 0) { ?>
				<?php if (($a_suppliers_view->Pager->PageCount==1) && ($a_suppliers_view->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $a_suppliers_view->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $a_suppliers_view->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $a_suppliers_view->Pager->RecordCount ?></span>
				</div>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($a_suppliers_view->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_suppliers_view->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($a_suppliers_view->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $a_suppliers_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($a_suppliers_view->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_suppliers_view->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($a_suppliers_view->Pager)) $a_suppliers_view->Pager = new cPrevNextPager($a_suppliers_view->StartRec, $a_suppliers_view->DisplayRecs, $a_suppliers_view->TotalRecs) ?>
		<?php if ($a_suppliers_view->Pager->RecordCount > 0) { ?>
				<?php if (($a_suppliers_view->Pager->PageCount==1) && ($a_suppliers_view->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
						<div class="ewPager ewRec">
							<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $a_suppliers_view->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $a_suppliers_view->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $a_suppliers_view->Pager->RecordCount ?></span>
						</div>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($a_suppliers_view->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($a_suppliers_view->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $a_suppliers_view->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($a_suppliers_view->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($a_suppliers_view->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $a_suppliers_view->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fa_suppliersview" id="fa_suppliersview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_suppliers_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_suppliers_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_suppliers">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($a_suppliers->Supplier_ID->Visible) { // Supplier_ID ?>
	<tr id="r_Supplier_ID">
		<td><span id="elh_a_suppliers_Supplier_ID"><?php echo $a_suppliers->Supplier_ID->FldCaption() ?></span></td>
		<td data-name="Supplier_ID"<?php echo $a_suppliers->Supplier_ID->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_ID">
<span<?php echo $a_suppliers->Supplier_ID->ViewAttributes() ?>>
<?php echo $a_suppliers->Supplier_ID->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Supplier_Number->Visible) { // Supplier_Number ?>
	<tr id="r_Supplier_Number">
		<td><span id="elh_a_suppliers_Supplier_Number"><?php echo $a_suppliers->Supplier_Number->FldCaption() ?></span></td>
		<td data-name="Supplier_Number"<?php echo $a_suppliers->Supplier_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_Number">
<span<?php echo $a_suppliers->Supplier_Number->ViewAttributes() ?>>
<?php echo $a_suppliers->Supplier_Number->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Supplier_Name->Visible) { // Supplier_Name ?>
	<tr id="r_Supplier_Name">
		<td><span id="elh_a_suppliers_Supplier_Name"><?php echo $a_suppliers->Supplier_Name->FldCaption() ?></span></td>
		<td data-name="Supplier_Name"<?php echo $a_suppliers->Supplier_Name->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_Name">
<span<?php echo $a_suppliers->Supplier_Name->ViewAttributes() ?>>
<?php echo $a_suppliers->Supplier_Name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Address->Visible) { // Address ?>
	<tr id="r_Address">
		<td><span id="elh_a_suppliers_Address"><?php echo $a_suppliers->Address->FldCaption() ?></span></td>
		<td data-name="Address"<?php echo $a_suppliers->Address->CellAttributes() ?>>
<span id="el_a_suppliers_Address">
<span<?php echo $a_suppliers->Address->ViewAttributes() ?>>
<?php echo $a_suppliers->Address->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->City->Visible) { // City ?>
	<tr id="r_City">
		<td><span id="elh_a_suppliers_City"><?php echo $a_suppliers->City->FldCaption() ?></span></td>
		<td data-name="City"<?php echo $a_suppliers->City->CellAttributes() ?>>
<span id="el_a_suppliers_City">
<span<?php echo $a_suppliers->City->ViewAttributes() ?>>
<?php echo $a_suppliers->City->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Country->Visible) { // Country ?>
	<tr id="r_Country">
		<td><span id="elh_a_suppliers_Country"><?php echo $a_suppliers->Country->FldCaption() ?></span></td>
		<td data-name="Country"<?php echo $a_suppliers->Country->CellAttributes() ?>>
<span id="el_a_suppliers_Country">
<span<?php echo $a_suppliers->Country->ViewAttributes() ?>>
<?php echo $a_suppliers->Country->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Contact_Person->Visible) { // Contact_Person ?>
	<tr id="r_Contact_Person">
		<td><span id="elh_a_suppliers_Contact_Person"><?php echo $a_suppliers->Contact_Person->FldCaption() ?></span></td>
		<td data-name="Contact_Person"<?php echo $a_suppliers->Contact_Person->CellAttributes() ?>>
<span id="el_a_suppliers_Contact_Person">
<span<?php echo $a_suppliers->Contact_Person->ViewAttributes() ?>>
<?php echo $a_suppliers->Contact_Person->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Phone_Number->Visible) { // Phone_Number ?>
	<tr id="r_Phone_Number">
		<td><span id="elh_a_suppliers_Phone_Number"><?php echo $a_suppliers->Phone_Number->FldCaption() ?></span></td>
		<td data-name="Phone_Number"<?php echo $a_suppliers->Phone_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Phone_Number">
<span<?php echo $a_suppliers->Phone_Number->ViewAttributes() ?>>
<?php echo $a_suppliers->Phone_Number->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->_Email->Visible) { // Email ?>
	<tr id="r__Email">
		<td><span id="elh_a_suppliers__Email"><?php echo $a_suppliers->_Email->FldCaption() ?></span></td>
		<td data-name="_Email"<?php echo $a_suppliers->_Email->CellAttributes() ?>>
<span id="el_a_suppliers__Email">
<span<?php echo $a_suppliers->_Email->ViewAttributes() ?>>
<?php echo $a_suppliers->_Email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Mobile_Number->Visible) { // Mobile_Number ?>
	<tr id="r_Mobile_Number">
		<td><span id="elh_a_suppliers_Mobile_Number"><?php echo $a_suppliers->Mobile_Number->FldCaption() ?></span></td>
		<td data-name="Mobile_Number"<?php echo $a_suppliers->Mobile_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Mobile_Number">
<span<?php echo $a_suppliers->Mobile_Number->ViewAttributes() ?>>
<?php echo $a_suppliers->Mobile_Number->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Notes->Visible) { // Notes ?>
	<tr id="r_Notes">
		<td><span id="elh_a_suppliers_Notes"><?php echo $a_suppliers->Notes->FldCaption() ?></span></td>
		<td data-name="Notes"<?php echo $a_suppliers->Notes->CellAttributes() ?>>
<span id="el_a_suppliers_Notes">
<span<?php echo $a_suppliers->Notes->ViewAttributes() ?>>
<?php echo $a_suppliers->Notes->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Balance->Visible) { // Balance ?>
	<tr id="r_Balance">
		<td><span id="elh_a_suppliers_Balance"><?php echo $a_suppliers->Balance->FldCaption() ?></span></td>
		<td data-name="Balance"<?php echo $a_suppliers->Balance->CellAttributes() ?>>
<span id="el_a_suppliers_Balance">
<span<?php echo $a_suppliers->Balance->ViewAttributes() ?>>
<?php echo $a_suppliers->Balance->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Is_Stock_Available->Visible) { // Is_Stock_Available ?>
	<tr id="r_Is_Stock_Available">
		<td><span id="elh_a_suppliers_Is_Stock_Available"><?php echo $a_suppliers->Is_Stock_Available->FldCaption() ?></span></td>
		<td data-name="Is_Stock_Available"<?php echo $a_suppliers->Is_Stock_Available->CellAttributes() ?>>
<span id="el_a_suppliers_Is_Stock_Available">
<span<?php echo $a_suppliers->Is_Stock_Available->ViewAttributes() ?>>
<?php echo $a_suppliers->Is_Stock_Available->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Date_Added->Visible) { // Date_Added ?>
	<tr id="r_Date_Added">
		<td><span id="elh_a_suppliers_Date_Added"><?php echo $a_suppliers->Date_Added->FldCaption() ?></span></td>
		<td data-name="Date_Added"<?php echo $a_suppliers->Date_Added->CellAttributes() ?>>
<span id="el_a_suppliers_Date_Added">
<span<?php echo $a_suppliers->Date_Added->ViewAttributes() ?>>
<?php echo $a_suppliers->Date_Added->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Added_By->Visible) { // Added_By ?>
	<tr id="r_Added_By">
		<td><span id="elh_a_suppliers_Added_By"><?php echo $a_suppliers->Added_By->FldCaption() ?></span></td>
		<td data-name="Added_By"<?php echo $a_suppliers->Added_By->CellAttributes() ?>>
<span id="el_a_suppliers_Added_By">
<span<?php echo $a_suppliers->Added_By->ViewAttributes() ?>>
<?php echo $a_suppliers->Added_By->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Date_Updated->Visible) { // Date_Updated ?>
	<tr id="r_Date_Updated">
		<td><span id="elh_a_suppliers_Date_Updated"><?php echo $a_suppliers->Date_Updated->FldCaption() ?></span></td>
		<td data-name="Date_Updated"<?php echo $a_suppliers->Date_Updated->CellAttributes() ?>>
<span id="el_a_suppliers_Date_Updated">
<span<?php echo $a_suppliers->Date_Updated->ViewAttributes() ?>>
<?php echo $a_suppliers->Date_Updated->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($a_suppliers->Updated_By->Visible) { // Updated_By ?>
	<tr id="r_Updated_By">
		<td><span id="elh_a_suppliers_Updated_By"><?php echo $a_suppliers->Updated_By->FldCaption() ?></span></td>
		<td data-name="Updated_By"<?php echo $a_suppliers->Updated_By->CellAttributes() ?>>
<span id="el_a_suppliers_Updated_By">
<span<?php echo $a_suppliers->Updated_By->ViewAttributes() ?>>
<?php echo $a_suppliers->Updated_By->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
<?php if ($a_suppliers->Export == "") { ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($a_suppliers_view->Pager)) $a_suppliers_view->Pager = new cNumericPager($a_suppliers_view->StartRec, $a_suppliers_view->DisplayRecs, $a_suppliers_view->TotalRecs, $a_suppliers_view->RecRange) ?>
		<?php if ($a_suppliers_view->Pager->RecordCount > 0) { ?>
				<?php if (($a_suppliers_view->Pager->PageCount==1) && ($a_suppliers_view->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<div class="ewPager ewRec">
					<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $a_suppliers_view->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $a_suppliers_view->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $a_suppliers_view->Pager->RecordCount ?></span>
				</div>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($a_suppliers_view->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_suppliers_view->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($a_suppliers_view->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $a_suppliers_view->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($a_suppliers_view->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_suppliers_view->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($a_suppliers_view->Pager)) $a_suppliers_view->Pager = new cPrevNextPager($a_suppliers_view->StartRec, $a_suppliers_view->DisplayRecs, $a_suppliers_view->TotalRecs) ?>
		<?php if ($a_suppliers_view->Pager->RecordCount > 0) { ?>
				<?php if (($a_suppliers_view->Pager->PageCount==1) && ($a_suppliers_view->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
						<div class="ewPager ewRec">
							<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $a_suppliers_view->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $a_suppliers_view->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $a_suppliers_view->Pager->RecordCount ?></span>
						</div>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($a_suppliers_view->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($a_suppliers_view->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $a_suppliers_view->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($a_suppliers_view->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($a_suppliers_view->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_suppliers_view->PageUrl() ?>start=<?php echo $a_suppliers_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $a_suppliers_view->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php
	if (in_array("a_purchases", explode(",", $a_suppliers->getCurrentDetailTable())) && $a_purchases->DetailView) {
?>
<?php if ($a_suppliers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("a_purchases", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "a_purchasesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("a_stock_items", explode(",", $a_suppliers->getCurrentDetailTable())) && $a_stock_items->DetailView) {
?>
<?php if ($a_suppliers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("a_stock_items", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "a_stock_itemsgrid.php" ?>
<?php } ?>
</form>
<?php if ($a_suppliers->Export == "") { ?>
<script type="text/javascript">
fa_suppliersview.Init();
</script>
<?php } ?>
<?php
$a_suppliers_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($a_suppliers->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if ($a_suppliers->Export == "") { ?>
<script type="text/javascript">
$('a.ewDelete').attr('onclick', 'return alertifyDeleteFromView(this)'); function alertifyDeleteFromView(obj) { <?php global $Language; ?> alertify.confirm("<?php echo $Language->Phrase('AlertifyDeleteConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyProcessing'); ?>"); window.location = obj.href; } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_suppliers_view->Page_Terminate();
?>
