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

$login = NULL; // Initialize page object first

class clogin extends cusers {

	// Page ID
	var $PageID = 'login';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Page object name
	var $PageObjName = 'login';

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
		$this->TokenTimeout = 48 * 60 * 60; // 48 hours for login

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}
		if (!isset($GLOBALS["users"])) $GLOBALS["users"] = &$this;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'login', TRUE);

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
		if (!isset($_SESSION['table_users_views'])) { 
			$_SESSION['table_users_views'] = 0;
		}
		$_SESSION['table_users_views'] = $_SESSION['table_users_views']+1;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();

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

	// CAPTCHA
	var $captcha;

	// Validate Captcha
	function ValidateCaptcha() {
		return ($this->captcha == @$_SESSION["EW_CAPTCHA_CODE"]);
	}

	// Reset Captcha
	function ResetCaptcha() {
		$_SESSION["EW_CAPTCHA_CODE"] = ew_Random();
	}
	var $Username;
	var $LoginType;

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language, $UserProfile, $gsFormError;
		global $Breadcrumb;
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb = new cBreadcrumb;
		$Breadcrumb->Add("login", "LoginPage", $url, "", "", TRUE); // v11.0.4
		$sPassword = "";
		$sLastUrl = $Security->LastUrl(); // Get last URL
		if ($sLastUrl == "")
			$sLastUrl = "index.php";

		// If session expired, show session expired message
		if (@$_GET["expired"] == "1")
			$this->setFailureMessage($Language->Phrase("SessionExpired"));
		if (IsLoggingIn()) {
			$this->Username = @$_SESSION[EW_SESSION_USER_PROFILE_USER_NAME];
			$sPassword = @$_SESSION[EW_SESSION_USER_PROFILE_PASSWORD];
			$this->LoginType = @$_SESSION[EW_SESSION_USER_PROFILE_LOGIN_TYPE];
			$bValidPwd = $Security->ValidateUser($this->Username, $sPassword, FALSE);
			if ($bValidPwd) {
				$_SESSION[EW_SESSION_USER_PROFILE_USER_NAME] = "";
				$_SESSION[EW_SESSION_USER_PROFILE_PASSWORD] = "";
				$_SESSION[EW_SESSION_USER_PROFILE_LOGIN_TYPE] = "";
			}
		} else {
			if (!$Security->IsLoggedIn())
				$Security->AutoLogin();
			$Security->LoadUserLevel(); // Load user level
			$this->Username = ""; // Initialize
			$encrypted = FALSE; // v12
			if (isset($_POST["username"])) {
				$this->Username = ew_RemoveXSS(ew_StripSlashes($_POST["username"]));
				$sPassword = ew_RemoveXSS(ew_StripSlashes(@$_POST["password"]));
				$this->LoginType = strtolower(ew_RemoveXSS(@$_POST["type"]));
			} else if (EW_ALLOW_LOGIN_BY_URL && isset($_GET["username"])) {
				$this->Username = ew_RemoveXSS(ew_StripSlashes($_GET["username"]));
				$sPassword = ew_RemoveXSS(ew_StripSlashes(@$_GET["password"]));
				$this->LoginType = strtolower(ew_RemoveXSS(@$_GET["type"]));
				$encrypted = !empty($_GET["encrypted"]);
			} // v12
			if ($this->Username <> "") {
				$bValidate = $this->ValidateForm($this->Username, $sPassword);
				if (!$bValidate)
					$this->setFailureMessage($gsFormError);
				$_SESSION[EW_SESSION_USER_LOGIN_TYPE] = $this->LoginType; // Save user login type
				$_SESSION[EW_SESSION_USER_PROFILE_USER_NAME] = $this->Username; // Save login user name
				$_SESSION[EW_SESSION_USER_PROFILE_LOGIN_TYPE] = $this->LoginType; // Save login type

				// Max login attempt checking
				if ($UserProfile->ExceedLoginRetry($this->Username)) {
					$bValidate = FALSE;

					// $this->setFailureMessage(str_replace("%t", EW_USER_PROFILE_RETRY_LOCKOUT, $Language->Phrase("ExceedMaxRetry")));
					// Begin of modification How Long User Should be Allowed Login in the Messages When Failed Login Exceeds the Maximum, by Masino Sinaga, May 12, 2012

                    $this->setFailureMessage(str_replace("%t", Duration( date("Y-m-d H:i:s"), CurrentDateTime_Add_Minutes( $UserProfile->getValue( EW_USER_PROFILE_LAST_BAD_LOGIN_DATE_TIME), EW_USER_PROFILE_RETRY_LOCKOUT)), $Language->Phrase("ExceedMaxRetryNew")));

					// End of modification How Long User Should be Allowed Login in the Messages When Failed Login Exceeds the Maximum, by Masino Sinaga, May 12, 2012
				}
			} else {
				if ($Security->IsLoggedIn()) {
					if ($this->getFailureMessage() == "")
						$this->Page_Terminate($sLastUrl); // Return to last accessed page
				}
				$bValidate = FALSE;

				// Restore settings
				if (@$_COOKIE[EW_PROJECT_NAME]['Checksum'] == strval(crc32(md5(EW_RANDOM_KEY))))
					$this->Username = ew_Decrypt(@$_COOKIE[EW_PROJECT_NAME]['Username']);
				if (@$_COOKIE[EW_PROJECT_NAME]['AutoLogin'] == "autologin") {
					$this->LoginType = "a";
				} elseif (@$_COOKIE[EW_PROJECT_NAME]['AutoLogin'] == "rememberusername") {
					$this->LoginType = "u";
				} else {
					$this->LoginType = "";
				}
			}
			$bValidPwd = FALSE;
			if (MS_SHOW_CAPTCHA_ON_LOGIN_PAGE) {

		// CAPTCHA checking
		if (ew_IsHttpPost()) {
			$this->captcha = @$_POST["captcha"];
			if (!$this->ValidateCaptcha()) { // CAPTCHA unmatched
				$this->setFailureMessage($Language->Phrase("EnterValidateCode")); // Set message
				$bValidate = FALSE;
			}
		}
		if (!$bValidate) {
			$this->ResetCaptcha();
		}
			}
			if ($bValidate) {

				// Call Logging In event
				$bValidate = $this->User_LoggingIn($this->Username, $sPassword);
				if ($bValidate) {
					$bValidPwd = $Security->ValidateUser($this->Username, $sPassword, FALSE, $encrypted); // Manual login v12
					if (!$bValidPwd) {

						// Password expired, force change password
						if (IsPasswordExpired()) {
							$this->setFailureMessage($Language->Phrase("PasswordExpired"));
							$this->Page_Terminate("changepwd.php");
						}
						if ($this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("InvalidUidPwd")); // Invalid user id/password

					// Password changed date not initialized, set as today
					} elseif ($UserProfile->EmptyPasswordChangedDate($this->Username)) {
						$UserProfile->SetValue(EW_USER_PROFILE_LAST_PASSWORD_CHANGED_DATE, ew_StdCurrentDate());
						$UserProfile->SaveProfileToDatabase($this->Username);
					}
				} else {
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("LoginCancelled")); // Login cancelled
				}
			}
		}
		if ($bValidPwd) {

			// Write cookies
			if ($this->LoginType == "a") { // Auto login
				setcookie(EW_PROJECT_NAME . '[AutoLogin]',  "autologin", EW_COOKIE_EXPIRY_TIME); // Set autologin cookie
				setcookie(EW_PROJECT_NAME . '[Username]', ew_Encrypt($this->Username), EW_COOKIE_EXPIRY_TIME); // Set user name cookie
				setcookie(EW_PROJECT_NAME . '[Password]', ew_Encrypt($sPassword), EW_COOKIE_EXPIRY_TIME); // Set password cookie
				setcookie(EW_PROJECT_NAME . '[Checksum]', crc32(md5(EW_RANDOM_KEY)), EW_COOKIE_EXPIRY_TIME);
			} elseif ($this->LoginType == "u") { // Remember user name
				setcookie(EW_PROJECT_NAME . '[AutoLogin]', "rememberusername", EW_COOKIE_EXPIRY_TIME); // Set remember user name cookie
				setcookie(EW_PROJECT_NAME . '[Username]', ew_Encrypt($this->Username), EW_COOKIE_EXPIRY_TIME); // Set user name cookie
				setcookie(EW_PROJECT_NAME . '[Checksum]', crc32(md5(EW_RANDOM_KEY)), EW_COOKIE_EXPIRY_TIME);
			} else {
				setcookie(EW_PROJECT_NAME . '[AutoLogin]', "", EW_COOKIE_EXPIRY_TIME); // Clear auto login cookie
			}

			// Begin of modification by Masino Sinaga, for saving the last login date time, November 6, 2011
			$UserProfile->Profile[MS_USER_PROFILE_LAST_LOGIN_DATE_TIME] = ew_StdCurrentDateTime();
			$UserProfile->SaveProfileToDatabase($this->Username);

			// End of modification by Masino Sinaga, for saving the last login date time, November 6, 2011
			// Call loggedin event

			$this->User_LoggedIn($this->Username);

			// Begin of modification Load Sessions for Application Settings and User Preferences, by Masino Sinaga, September 22, 2014
			// LoadApplicationSettings();
			// LoadUserPreferences();
			// End of modification Load Sessions for Application Settings and User Preferences, by Masino Sinaga, September 22, 2014

			$this->Page_Terminate($sLastUrl); // Return to last accessed URL
		} elseif ($this->Username <> "" && $sPassword <> "") {

			// Call user login error event
			$this->User_LoginError($this->Username, $sPassword);
		}
	}

	//
	// Validate form
	//
	function ValidateForm($usr, $pwd) {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (trim($usr) == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterUid"));
		}
		if (trim($pwd) == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterPwd"));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form Custom Validate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
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

	// User Logging In event
	function User_LoggingIn($usr, &$pwd) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// User Logged In event
	function User_LoggedIn($usr) {

		//echo "User Logged In";
	}

	// User Login Error event
	function User_LoginError($usr, $pwd) {

		//echo "User Login Error";
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
if (!isset($login)) $login = new clogin();

// Page init
$login->Page_Init();

// Page main
$login->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$login->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<script type="text/javascript" src="phpjs/login_dialog.js"></script>
<script type="text/javascript">
var flogin = new ew_Form("flogin");

// Validate function
flogin.Validate = function()
{
	var fobj = this.Form;
	if (!this.ValidateRequired)
		return true; // Ignore validation
	if (!ew_HasValue(fobj.username))
		return this.OnError(fobj.username, ewLanguage.Phrase("EnterUid"));
	if (!ew_HasValue(fobj.password))
		return this.OnError(fobj.password, ewLanguage.Phrase("EnterPwd"));
<?php if (MS_SHOW_CAPTCHA_ON_LOGIN_PAGE == TRUE) { ?>
		if (fobj.captcha && !ew_HasValue(fobj.captcha))
			return this.OnError(fobj.captcha, ewLanguage.Phrase("EnterValidateCode"));
<?php } ?>

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// Form_CustomValidate function
flogin.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Requires js validation
<?php if (EW_CLIENT_VALIDATE) { ?>
flogin.ValidateRequired = true;
<?php } else { ?>
flogin.ValidateRequired = false;
<?php } ?>
</script>
<div class="ewToolbar">
<?php if (MS_SHOW_BREADCRUMBLINKS_ON_LOGIN_PAGE) { ?>
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php } ?>
<?php if (@MS_LANGUAGE_SELECTOR_VISIBILITY == "belowheader") { ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $login->ShowPageHeader(); ?>
<?php
$login->ShowMessage();
?>
<form name="flogin" id="flogin" class="form-horizontal ewForm ewLoginForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if (MS_LOGIN_WINDOW_TYPE=="default" || MS_LOGIN_WINDOW_TYPE=="") { ?>
<div class="col-sm-8 col-sm-offset-2">
<div class="panel <?php echo MS_LOGIN_FORM_PANEL_TYPE; ?>">
<div class="panel-heading"><strong><?php echo $Language->Phrase("Login") ?></strong><?php if (@MS_SHOW_HELP_ONLINE) { ?> &nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a> <?php } ?></div>
<div class="panel-body">
<br>
<?php if ($login->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $login->Token ?>">
<?php } ?>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="username"><?php echo $Language->Phrase("Username") ?></label>
		<div class="col-sm-8"><input type="text" name="username" id="username" class="form-control ewControl" value="<?php echo ew_HtmlEncode($login->Username) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Username")) ?>"></div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="password"><?php echo $Language->Phrase("Password") ?></label>
		<div class="col-sm-8"><input type="password" name="password" id="password" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Password")) ?>"></div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<a id="ewLoginOptions" class="collapsed" data-toggle="collapse" data-target="#flogin_options"><?php echo $Language->Phrase("LoginOptions") ?> <span class="icon-arrow"></span></a>
			<div id="flogin_options" class="collapse">
					<div class="radio ewRadio">
					<label for="type1"><input type="radio" name="type" id="type1" value="a"<?php if ($login->LoginType == "a") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AutoLogin") ?></label>
					</div>
					<div class="radio ewRadio">
					<label for="type2"><input type="radio" name="type" id="type2" value="u"<?php if ($login->LoginType == "u") { ?>  checked="checked"<?php } ?>><?php echo $Language->Phrase("SaveUserName") ?></label>
					</div>
					<div class="radio ewRadio">
					<label for="type3"><input type="radio" name="type" id="type3" value=""<?php if ($login->LoginType == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AlwaysAsk") ?></label>
					</div>
			</div>
		</div>
	</div>
<?php if (MS_SHOW_CAPTCHA_ON_LOGIN_PAGE == TRUE) { ?>
<!-- captcha html (begin) -->
<div class="form-group">
	<div class=" col-sm-offset-4 col-sm-8 ">
	<img src="ewcaptcha.php" alt="Security Image" style="width: 200px; height: 50px;"><br><br>
	<input type="text" name="captcha" id="captcha" class="form-control" size="30" placeholder="<?php echo $Language->Phrase("EnterValidateCode") ?>">
	</div>
</div>
<!-- captcha html (end) -->
<?php } ?>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("Login") ?></button>
			<button class="btn btn-danger ewButton" name="btnreset" id="btnreset" type="reset"><?php echo $Language->Phrase("Reset") ?></button>
		</div>
	</div>
</div>
<div class="panel-footer <?php echo MS_LOGIN_FORM_PANEL_TYPE; ?>">
	<div>
		<a class="ewLink ewLinkSeparator" href="forgotpwd.php"><?php echo $Language->Phrase("ForgotPwd") ?></a>
		<?php if (@MS_USER_REGISTRATION) { ?>
		<a class="ewLink ewLinkSeparator" href="register.php"><?php echo $Language->Phrase("Register") ?></a>
		<?php } ?>
	</div>
</div>
</div>
</div>
<?php } else { // else for Window Type, this is for "popup" ?>
<div id="msLoginDialog" class="modal fade">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">x</span></button><h4 class="modal-title"><?php echo $Language->Phrase("Login") ?><?php if (@MS_SHOW_HELP_ONLINE) { ?> &nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a> <?php } ?></h4></div>
<div class="modal-body">
<br>
<?php if ($login->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $login->Token ?>">
<?php } ?>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="username"><?php echo $Language->Phrase("Username") ?></label>
		<div class="col-sm-8"><input type="text" name="username" id="username" class="form-control ewControl" value="<?php echo ew_HtmlEncode($login->Username) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Username")) ?>"></div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="password"><?php echo $Language->Phrase("Password") ?></label>
		<div class="col-sm-8"><input type="password" name="password" id="password" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Password")) ?>"></div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<a id="ewLoginOptions" class="collapsed" data-toggle="collapse" data-target="#flogin_options"><?php echo $Language->Phrase("LoginOptions") ?> <span class="icon-arrow"></span></a>
			<div id="flogin_options" class="collapse">
					<div class="radio ewRadio">
					<label for="type1"><input type="radio" name="type" id="type1" value="a"<?php if ($login->LoginType == "a") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AutoLogin") ?></label>
					</div>
					<div class="radio ewRadio">
					<label for="type2"><input type="radio" name="type" id="type2" value="u"<?php if ($login->LoginType == "u") { ?>  checked="checked"<?php } ?>><?php echo $Language->Phrase("SaveUserName") ?></label>
					</div>
					<div class="radio ewRadio">
					<label for="type3"><input type="radio" name="type" id="type3" value=""<?php if ($login->LoginType == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AlwaysAsk") ?></label>
					</div>
			</div>
		</div>
	</div>
<?php if (MS_SHOW_CAPTCHA_ON_LOGIN_PAGE == TRUE) { ?>
<!-- captcha html (begin) -->
<div class="form-group">
	<div class=" col-sm-offset-4 col-sm-8 ">
	<img src="ewcaptcha.php" alt="Security Image" style="width: 200px; height: 50px;"><br><br>
	<input type="text" name="captcha" id="captcha" class="form-control" size="30" placeholder="<?php echo $Language->Phrase("EnterValidateCode") ?>">
	</div>
</div>
<!-- captcha html (end) -->
<?php } ?>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("Login") ?></button>
			<button class="btn btn-danger ewButton" name="btnreset" id="btnreset" type="reset"><?php echo $Language->Phrase("Reset") ?></button>
		</div>
	</div>
</div>
<div class="modal-footer">
	<div class="pull-left">
		<a class="ewLink ewLinkSeparator" href="forgotpwd.php"><?php echo $Language->Phrase("ForgotPwd") ?></a>
		<?php if (@MS_USER_REGISTRATION) { ?>
		<a class="ewLink ewLinkSeparator" href="register.php"><?php echo $Language->Phrase("Register") ?></a>
		<?php } ?>
	</div>
</div>
</div>
</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
flogin.Init();
$(document).ready(function(){
	$("#btnsubmit").button().click(function(){
		if (flogin.Validate() == true ) {
			alertify.success("<?php echo Language()->Phrase("AlertifyProcessing"); ?>");
			$('#msLoginDialog').slideUp(800);
		}
	});
<?php if (MS_LOGIN_WINDOW_TYPE=="popup") { ?>
  msLoginDialogShow(); 
  $('#msLoginDialog').on('shown.bs.modal', function () {
    $('#username').focus();
  });
<?php } else { ?>
  $("#username").focus();
<?php } ?>
});
</script>
<?php
$login->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

$(document).ready(function() {
	$('#username').val('admin');
	$('#password').val('master');
});
</script>
<?php include_once "footer.php" ?>
<?php
$login->Page_Terminate();
?>
