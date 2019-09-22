<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$BreadcrumbLinksDeleteSP = NULL; // Initialize page object first

class cBreadcrumbLinksDeleteSP {

	// Page ID
	var $PageID = 'BreadcrumbLinksDeleteSP';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Page object name
	var $PageObjName = 'BreadcrumbLinksDeleteSP';

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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'BreadcrumbLinksDeleteSP', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

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
		if (!isset($_SESSION['table_users_views'])) { 
			$_SESSION['table_users_views'] = 0;
		}
		$_SESSION['table_users_views'] = $_SESSION['table_users_views']+1;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (@MS_USE_CONSTANTS_IN_CONFIG_FILE == FALSE) {

			// Call this new function from userfn*.php file
			My_Global_Check();
		}

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

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language, $UserTableConn;
		global $PageTitle;
		$PageTitle = @$_GET["PageTitle"];

        //$this->setWarningMessage("Warning: Removing a parent breadcrumb link which has the children, will automatically delete all the children beneath it. Once you click the button, the deleting process cannot be undo. So, be careful!");
		$this->setWarningMessage($Language->Phrase("DeleteBreadcrumbLinksWarning"));
		if ( isset($_GET["PageTitle"]) ) {
			if ( $PageTitle != "" ) {	
			  $value = ew_ExecuteScalar("SELECT COUNT(*) FROM ".MS_MASINO_BREADCRUMBLINKS_TABLE."");
			  if ( $value > 0 ) {
					$pt = ew_ExecuteScalar("SELECT Page_Title FROM ".MS_MASINO_BREADCRUMBLINKS_TABLE." WHERE Page_Title = '".$PageTitle."'");
					if ($pt == "") {

					  // $this->setFailureMessage("Failed. Page Title does not exist in breadcrumblinks table.");
					  $this->setFailureMessage($Language->Phrase("DeleteBreadcrumbLinksNotFOund"));
				   } else {
					if (EW_IS_MYSQL) {
					 $rsb = $UserTableConn->Execute("CALL ".MS_BREADCRUMB_LINKS_DELETE_SP."('".$PageTitle."')");
					} else {
					 $rsb = $UserTableConn->Execute("".MS_BREADCRUMB_LINKS_DELETE_SP."('".$PageTitle."')");
					}
					  if ($rsb->RecordCount()==0) {  

						//$this->setSuccessMessage("Breadcrumb link <strong>".$PageTitle."</strong> has been successfully deleted.");
						$this->setSuccessMessage(sprintf($Language->Phrase("DeleteBreadcrumbLinksSuccess"), $PageTitle));
					  } else {

						//$this->setFailureMessage("Failed. Please check your data.");
						$this->setFailureMessage($Language->Phrase("DeleteBreadcrumbLinksFailed"));
					  }
					}
			  } else {

				//$this->setFailureMessage("Failed. There is no data in breadcrumblinks table.");
				$this->setFailureMessage($Language->Phrase("DeleteBreadcrumbLinksNoData"));
			  }
			} else {

			  //$this->setFailureMessage("Please select the breadcrumb link record or Page Title.");
			  $this->setFailureMessage($Language->Phrase("DeleteBreadcrumbLinksNoDetails"));
			}
		}
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
if (!isset($BreadcrumbLinksDeleteSP)) $BreadcrumbLinksDeleteSP = new cBreadcrumbLinksDeleteSP();

// Page init
$BreadcrumbLinksDeleteSP->Page_Init();

// Page main
$BreadcrumbLinksDeleteSP->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$BreadcrumbLinksDeleteSP->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $BreadcrumbLinksDeleteSP->ShowPageHeader(); ?>
<?php
$BreadcrumbLinksDeleteSP->ShowMessage();
?>
<form name="fdeletebreadcrumblink" id="fdeletebreadcrumblink" method="get" action="<?php echo ew_CurrentPage() ?>" class="ewForm form-horizontal">
<div class="col-sm-8 col-sm-offset-2">
<div class="panel panel-default">
<div class="panel-heading"><strong><?php echo $Language->Phrase("DeleteBreadcrumbLinks") ?></strong><?php if (MS_SHOW_HELP_ONLINE) { ?>&nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a><?php } ?></div>
<div class="panel-body">
<br>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="pagetitle">Page Title <?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8">
		<?php
		global $UserTableConn;
		$sSql = "SELECT Page_Title FROM ".MS_MASINO_BREADCRUMBLINKS_TABLE." ORDER BY Page_Title ASC";
		$rs = $UserTableConn->Execute($sSql);
		$cntRec = $rs->RecordCount();
		echo '<select id="PageTitle" name="PageTitle" class="form-control ewControl">';
		echo '<option value="" selected="selected">'.$Language->Phrase("PleaseSelect").'</option>';
		if ($cntRec > 0) {
		  $rs->MoveFirst();
		  while (!$rs->EOF) {
			$selected = ($rs->fields("Page_Title") == @$_GET["PageTitle"]) ? 'selected' : '';
			echo "<option value='".$rs->fields("Page_Title")."' ". $selected. ">".$rs->fields("Page_Title")."</option>";
			$rs->MoveNext();
		  }
		  $rs->Close();  
		}
		echo "</select>";
		?>  
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="btnAction">&nbsp;</label>
		<div class="col-sm-8">
			<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBreadcrumbLinks") ?></button>
		</div>
	</div>
</div>
<div class="panel-footer panel-default">
	<div><a href="breadcrumblinksaddsp.php"><?php echo $Language->Phrase("AddBreadcrumbLinks") ?></a> | <a href="breadcrumblinkschecksp.php"><?php echo $Language->Phrase("CheckBreadcrumbLinks") ?></a> | <a href="breadcrumblinksmovesp.php"><?php echo $Language->Phrase("MoveBreadcrumbLinks") ?></a></div>
</div>
</div>
</div>
</form>
<script type="text/javascript">
var fdeletebreadcrumblink = new ew_Form("fdeletebreadcrumblink");
fdeletebreadcrumblink.Init();
</script>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$BreadcrumbLinksDeleteSP->Page_Terminate();
?>
