<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "userlevelsinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$userpriv = NULL; // Initialize page object first

class cuserpriv extends cuserlevels {

	// Page ID
	var $PageID = 'userpriv';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Page object name
	var $PageObjName = 'userpriv';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
		return TRUE;
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

		// Table object (userlevels)
		if (!isset($GLOBALS["userlevels"]) || get_class($GLOBALS["userlevels"]) == "cuserlevels") {
			$GLOBALS["userlevels"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["userlevels"];
		}
		if (!isset($GLOBALS["userlevels"])) $GLOBALS["userlevels"] = &$this;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'userpriv', TRUE);

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
		if (!isset($_SESSION['table_userlevels_views'])) { 
			$_SESSION['table_userlevels_views'] = 0;
		}
		$_SESSION['table_userlevels_views'] = $_SESSION['table_userlevels_views']+1;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel(CurrentProjectID() . 'userlevels');
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanAdmin()) {
			$Security->SaveLastUrl();
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
	var $TempPriv;
	var $Disabled;
	var $Privileges;
	var $TableNameCount;
	var $ReportLanguage;
	var $UserLevelList = array();
	var $UserLevelPrivList = array();
	var $TableList = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;
		global $EW_RELATED_LANGUAGE_FOLDER;
		global $Breadcrumb;
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb = new cBreadcrumb;
		$Breadcrumb->Add("list", "userlevels", "userlevelslist.php", "", "userlevels");
		$Breadcrumb->Add("userpriv", "UserLevelPermission", $url); // v11.0.4

		// Try to load PHP Report Maker language file
		// Note: The langauge IDs must be the same in both projects

		$Security->LoadUserLevelFromConfigFile($this->UserLevelList, $this->UserLevelPrivList, $this->TableList, TRUE);
		if ($EW_RELATED_LANGUAGE_FOLDER <> "")
			$this->ReportLanguage = new cLanguage($EW_RELATED_LANGUAGE_FOLDER);
		$this->TableNameCount = count($this->TableList);
		$this->Privileges = &ew_InitArray($this->TableNameCount, 0);

		// Get action
		if (@$_POST["a_edit"] == "") {
			$this->CurrentAction = "I"; // Display with input box

			// Load key from QueryString
			if (@$_GET["User_Level_ID"] <> "") {
				$this->User_Level_ID->setQueryStringValue($_GET["User_Level_ID"]);
			} else {
				$this->Page_Terminate("userlevelslist.php"); // Return to list
			}
			if ($this->User_Level_ID->QueryStringValue == "-1") {
				$this->Disabled = " disabled=\"disabled\"";
			} else {
				$this->Disabled = "";
			}
		} else {
			$this->CurrentAction = $_POST["a_edit"];

			// Get fields from form
			$this->User_Level_ID->setFormValue($_POST["x_User_Level_ID"]);

			// Begin of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012
			for ($i = 0; $i < $this->TableNameCount; $i++) {
				if (defined("EW_USER_LEVEL_COMPAT")) {
					$this->Privileges[$i] = intval(@$_POST["Add_" . $i]) + 
						intval(@$_POST["Delete_" . $i]) + intval(@$_POST["Edit_" . $i]) +
						intval(@$_POST["List_" . $i]) + intval(@$_POST["Printer_" . $i]) +
						intval(@$_POST["HTML_" . $i]) + intval(@$_POST["Excel_" . $i]) +
						intval(@$_POST["Word_" . $i]) + intval(@$_POST["PDF_" . $i]) +
						intval(@$_POST["XML_" . $i]) + intval(@$_POST["CSV_" . $i]) +
						intval(@$_POST["Email_" . $i]);
				} else {
					$this->Privileges[$i] = intval(@$_POST["Add_" . $i]) +
						intval(@$_POST["Delete_" . $i]) + intval(@$_POST["Edit_" . $i]) +
						intval(@$_POST["List_" . $i]) + intval(@$_POST["View_" . $i]) +
						intval(@$_POST["Search_" . $i]) + intval(@$_POST["Printer_" . $i]) +
						intval(@$_POST["HTML_" . $i]) + intval(@$_POST["Excel_" . $i]) +
						intval(@$_POST["Word_" . $i]) + intval(@$_POST["PDF_" . $i]) +
						intval(@$_POST["XML_" . $i]) + intval(@$_POST["CSV_" . $i]) +
						intval(@$_POST["Email_" . $i]);
				}
			}

			// End of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012
		}
		switch ($this->CurrentAction) {
			case "I": // Display
				if (!$Security->SetUpUserLevelEx()) // Get all User Level info
					$this->Page_Terminate("userlevelslist.php"); // Return to list
				break;
			case "U": // Update
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message

					// Alternatively, comment out the following line to go back to this page
					$this->Page_Terminate("userlevelslist.php"); // Return to list
				}
		}
	}

	// Update privileges
	function EditRow() {
		$c = &Conn(EW_USER_LEVEL_PRIV_DBID);
		for ($i = 0; $i < $this->TableNameCount; $i++) {
			$Sql = "SELECT * FROM " . EW_USER_LEVEL_PRIV_TABLE . " WHERE " . 
				EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = '" . ew_AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], EW_USER_LEVEL_PRIV_DBID) . "' AND " .
				EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $this->User_Level_ID->CurrentValue;
			$rs = $c->Execute($Sql);
			if ($rs && !$rs->EOF) {
				$Sql = "UPDATE " . EW_USER_LEVEL_PRIV_TABLE . " SET " . EW_USER_LEVEL_PRIV_PRIV_FIELD . " = " . $this->Privileges[$i] . " WHERE " .
					EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = '" . ew_AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], EW_USER_LEVEL_PRIV_DBID) . "' AND " .
					EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $this->User_Level_ID->CurrentValue;
				$c->Execute($Sql);
			} else {
				$Sql = "INSERT INTO " . EW_USER_LEVEL_PRIV_TABLE . " (" . EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . ", " . EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . ", " . EW_USER_LEVEL_PRIV_PRIV_FIELD . ") VALUES ('" . ew_AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], EW_USER_LEVEL_PRIV_DBID) . "', " . $this->User_Level_ID->CurrentValue . ", " . $this->Privileges[$i] . ")";
				$c->Execute($Sql);
			}
			if ($rs)
				$rs->Close();
		}
		return TRUE;
	}

	// Get table caption
	function GetTableCaption($i) {
		global $Language, $EW_RELATED_PROJECT_ID;
		$caption = "";
		if ($i < $this->TableNameCount) {
			$report = ($this->TableList[$i][4] == $EW_RELATED_PROJECT_ID);
			$other = (!$report && $this->TableList[$i][4] <> CurrentProjectID());
			if (!$report && !$other)
				$caption = $Language->TablePhrase($this->TableList[$i][1], "TblCaption");
            if ($report && is_object($this->ReportLanguage))
				$caption = $this->ReportLanguage->TablePhrase($this->TableList[$i][1], "TblCaption");
			if ($caption == "")
				$caption = $this->TableList[$i][2];
			if ($caption == "") {
				$caption = $this->TableList[$i][0];
				$caption = preg_replace('/^\{\w{8}-\w{4}-\w{4}-\w{4}-\w{12}\}/', '', $caption); // Remove project id
			}
			if ($report)
				$caption .= "<span class=\"ewUserprivProject\"> (" . $Language->Phrase("Report") . ")</span>";
			if ($other) {
				if ($this->TableList[$i][5] <> "") {
					$pathinfo = pathinfo($this->TableList[$i][5]);
					$ext = $pathinfo['extension'];
					$project = basename($this->TableList[$i][5], "." . $ext);
				} else {
					$project = $this->TableList[$i][4];
				}

				//$project = $this->TableList[$i][4]; // ** Uncomment to use project id
				$caption .= "<span class=\"ewUserprivProject\"> (" . $project . ")</span>";
			}
		}
		return $caption;
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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

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
if (!isset($userpriv)) $userpriv = new cuserpriv();

// Page init
$userpriv->Page_Init();

// Page main
$userpriv->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$userpriv->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "userpriv";
var CurrentForm = fuserpriv = new ew_Form("fuserpriv", "userpriv");

// Form_CustomValidate event
fuserpriv.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fuserpriv.ValidateRequired = true;
<?php } else { ?>
fuserpriv.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript" src="phpjs/ewscrolltable.min.js"></script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
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
<p><?php echo $Language->Phrase("UserLevel") ?><?php echo $Security->GetUserLevelName($userlevels->User_Level_ID->CurrentValue) ?> (<?php echo $userlevels->User_Level_ID->CurrentValue ?>)</p>
<?php
$userpriv->ShowMessage();
?>
<script type="text/javascript">
var fuserpriv = new ew_Form("fuserpriv");
</script>
<form name="fuserpriv" id="fuserpriv" class="form-inline ewForm ewUserprivForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($userpriv->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $userpriv->Token ?>">
<?php } ?>
<div class="ewGrid">
<div id="gmp_userpriv" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<!-- hidden tag for User Level ID -->
<input type="hidden" name="x_User_Level_ID" id="x_User_Level_ID" value="<?php echo $userlevels->User_Level_ID->CurrentValue ?>">
<table id="tbl_userpriv" class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
		<th><?php echo $Language->Phrase("TableOrView") ?></th>
		<th><?php echo $Language->Phrase("PermissionAddCopy") ?> <input type="checkbox" class="ewPriv" name="Add" id="Add" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionDelete") ?> <input type="checkbox" class="ewPriv" name="Delete" id="Delete" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionEdit") ?> <input type="checkbox" class="ewPriv" name="Edit" id="Edit" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
<?php if (defined("EW_USER_LEVEL_COMPAT")) { ?>
		<th><?php echo $Language->Phrase("PermissionListSearchView") ?> <input type="checkbox" class="ewPriv" name="List" id="List" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
<?php } else { ?>
		<th><?php echo $Language->Phrase("PermissionList") ?> <input type="checkbox" class="ewPriv" name="List" id="List" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionView") ?> <input type="checkbox" class="ewPriv" name="View" id="View" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionSearch") ?> <input type="checkbox" class="ewPriv" name="Search" id="Search" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
<?php } ?>
		<?php // Begin of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012 ?>
		<th><?php echo $Language->Phrase("PermissionPrinterFriendly") ?><input type="checkbox" class="ewPriv" name="Printer" id="Printer" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionExportToExcel") ?><input type="checkbox" class="ewPriv" name="Excel" id="Excel" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionExportToWord") ?><input type="checkbox" class="ewPriv" name="Word" id="Word" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionExportToHTML") ?><input type="checkbox" class="ewPriv" name="HTML" id="HTML" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionExportToXML") ?><input type="checkbox" class="ewPriv" name="XML" id="XML" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionExportToCSV") ?><input type="checkbox" class="ewPriv" name="CSV" id="CSV" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionExportToPDF") ?><input type="checkbox" class="ewPriv" name="PDF" id="PDF" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<th><?php echo $Language->Phrase("PermissionExportToEmail") ?><input type="checkbox" class="ewPriv" name="Email" id="Email" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></th>
		<td><?php echo $Language->Phrase("TableOrView") ?></td>
		<?php // End of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012 ?>
	</tr>
	</thead>
	<tbody>
<?php
for ($i = 0; $i < $userpriv->TableNameCount; $i++) {
	$userpriv->TempPriv = $Security->GetUserLevelPrivEx($userpriv->TableList[$i][4] . $userpriv->TableList[$i][0], $userlevels->User_Level_ID->CurrentValue);

		// Set row properties
		$userlevels->ResetAttrs();
?>
	<tr<?php echo $userlevels->RowAttributes() ?>>
		<td><?php echo $userpriv->GetTableCaption($i) ?></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="Add_<?php echo $i ?>" id="Add_<?php echo $i ?>" value="1"<?php if (($userpriv->TempPriv & EW_ALLOW_ADD) == EW_ALLOW_ADD) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="Delete_<?php echo $i ?>" id="Delete_<?php echo $i ?>" value="2"<?php if (($userpriv->TempPriv & EW_ALLOW_DELETE) == EW_ALLOW_DELETE) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="Edit_<?php echo $i ?>" id="Edit_<?php echo $i ?>" value="4"<?php if (($userpriv->TempPriv & EW_ALLOW_EDIT) == EW_ALLOW_EDIT) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
<?php if (defined("EW_USER_LEVEL_COMPAT")) { ?>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="List_<?php echo $i ?>" id="List_<?php echo $i ?>" value="8"<?php if (($userpriv->TempPriv & EW_ALLOW_LIST) == EW_ALLOW_LIST) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
<?php } else { ?>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="List_<?php echo $i ?>" id="List_<?php echo $i ?>" value="8"<?php if (($userpriv->TempPriv & EW_ALLOW_LIST) == EW_ALLOW_LIST) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="View_<?php echo $i ?>" id="View_<?php echo $i ?>" value="32"<?php if (($userpriv->TempPriv & EW_ALLOW_VIEW) == EW_ALLOW_VIEW) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="Search_<?php echo $i ?>" id="Search_<?php echo $i ?>" value="64"<?php if (($userpriv->TempPriv & EW_ALLOW_SEARCH) == EW_ALLOW_SEARCH) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
<?php } ?>
		<?php // Begin of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012 ?>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="Printer_<?php echo $i ?>" id="Printer_<?php echo $i ?>" value="128"<?php if (($userpriv->TempPriv & MS_ALLOW_EXPORT_TO_PRINT) == MS_ALLOW_EXPORT_TO_PRINT) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="Excel_<?php echo $i ?>" id="Excel_<?php echo $i ?>" value="256"<?php if (($userpriv->TempPriv & MS_ALLOW_EXPORT_TO_EXCEL) == MS_ALLOW_EXPORT_TO_EXCEL) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="Word_<?php echo $i ?>" id="Word_<?php echo $i ?>" value="512"<?php if (($userpriv->TempPriv & MS_ALLOW_EXPORT_TO_WORD) == MS_ALLOW_EXPORT_TO_WORD) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="HTML_<?php echo $i ?>" id="HTML_<?php echo $i ?>" value="1024"<?php if (($userpriv->TempPriv & MS_ALLOW_EXPORT_TO_HTML) == MS_ALLOW_EXPORT_TO_HTML) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="XML_<?php echo $i ?>" id="XML_<?php echo $i ?>" value="2048"<?php if (($userpriv->TempPriv & MS_ALLOW_EXPORT_TO_XML) == MS_ALLOW_EXPORT_TO_XML) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="CSV_<?php echo $i ?>" id="CSV_<?php echo $i ?>" value="4096"<?php if (($userpriv->TempPriv & MS_ALLOW_EXPORT_TO_CSV) == MS_ALLOW_EXPORT_TO_CSV) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="PDF_<?php echo $i ?>" id="PDF_<?php echo $i ?>" value="8192"<?php if (($userpriv->TempPriv & MS_ALLOW_EXPORT_TO_PDF) == MS_ALLOW_EXPORT_TO_PDF) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td class="ewCheckbox"><input type="checkbox" class="ewPriv" name="Email_<?php echo $i ?>" id="Email_<?php echo $i ?>" value="16384"<?php if (($userpriv->TempPriv & MS_ALLOW_EXPORT_TO_EMAIL) == MS_ALLOW_EXPORT_TO_EMAIL) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></td>
		<td><span class="phpmaker"><?php echo $userpriv->GetTableCaption($i) ?></span></td>
		<?php // End of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012 ?>
	</tr>
<?php } ?>
	</tbody>
</table>
</div>
</div>
<div class="ewDesktopButton">
<input type="hidden" name="a_list" id="a_list" value="">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"<?php echo $userpriv->Disabled ?>><?php echo $Language->Phrase("Update") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $userpriv->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fuserpriv.Init();
</script>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php if ($userlevels->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyUpdate(this)'); function alertifyUpdate(obj) { <?php global $Language; ?> if (fuserlevelsupdate.Validate() == true ) { alertify.confirm("<?php echo  $Language->Phrase('AlertifyEditConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyEdit'); ?>"); $("#fuserpriv").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php if ($userlevels->CurrentAction == "" || $userlevels->Export == "") { // Change && become || in order to add scroll table in Grid, by Masino Sinaga, August 3, 2014 ?>
<script type="text/javascript">
<?php if (MS_TABLE_WIDTH_STYLE==1) { // Begin of modification Optimizing Main Table Width to Maximum Width of Site, by Masino Sinaga, April 30, 2012 ?>
<?php $iWidthAdjustment = (MS_MENU_HORIZONTAL) ? 0 : 100; ?>
ew_ScrollableTable("gmp_userlevels", "<?php echo (MS_SCROLL_TABLE_WIDTH - $iWidthAdjustment); ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_userlevels_empty_table", "<?php echo (MS_SCROLL_TABLE_WIDTH - $iWidthAdjustment); ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } elseif (MS_TABLE_WIDTH_STYLE==2) { ?>
ew_ScrollableTable("gmp_userlevels", "<?php echo MS_SCROLL_TABLE_WIDTH; ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_userlevels_empty_table", "<?php echo MS_SCROLL_TABLE_WIDTH; ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } elseif (MS_TABLE_WIDTH_STYLE==3) { ?>
ew_ScrollableTable("gmp_userlevels", "100%", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
ew_ScrollableTable("gmp_userlevels_empty_table", "100%", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } // End of modification Optimizing Main Table Width to Maximum Width of Site, by Masino Sinaga, April 30, 2012 ?>
<?php } ?>
</script>
<script type="text/javascript">
<?php if (MS_TABLE_WIDTH_STYLE==1) { // Begin of modification Optimizing Main Table Width to Maximum Width of Site, by Masino Sinaga, April 30, 2012 ?>
ew_ScrollableTable("gmp_userpriv", "<?php echo MS_SCROLL_TABLE_WIDTH; ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } elseif (MS_TABLE_WIDTH_STYLE==2) { ?>
ew_ScrollableTable("gmp_userpriv", "<?php echo MS_SCROLL_TABLE_WIDTH; ?>px", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } elseif (MS_TABLE_WIDTH_STYLE==3) { ?>
ew_ScrollableTable("gmp_userpriv", "100%", "<?php echo MS_SCROLL_TABLE_HEIGHT; ?>px");
<?php } // End of modification Optimizing Main Table Width to Maximum Width of Site, by Masino Sinaga, April 30, 2012 ?>
</script>
<?php include_once "footer.php" ?>
<?php
$userpriv->Page_Terminate();
?>
