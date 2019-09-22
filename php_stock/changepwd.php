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

$changepwd = NULL; // Initialize page object first

class cchangepwd extends cusers {

	// Page ID
	var $PageID = 'changepwd';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Page object name
	var $PageObjName = 'changepwd';

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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}
		if (!isset($GLOBALS["users"])) $GLOBALS["users"] = &$this;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'changepwd', TRUE);

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
		if (!IsPasswordReset() && !IsPasswordExpired()) {
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn() || $Security->IsSysAdmin())
			$this->Page_Terminate(ew_GetUrl("login.php"));
		$Security->LoadCurrentUserLevel($this->ProjectID . 'users');
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
	var $OldPassword = "";
	var $NewPassword = "";
	var $ConfirmedPassword = "";

	// 
	// Page main
	//
	function Page_Main() {
		global $UserTableConn, $Language, $Security, $gsFormError;
		global $Breadcrumb;
		$Breadcrumb = new cBreadcrumb;
		$Breadcrumb->Add("changepwd", "ChangePwdPage", ew_CurrentUrl(), "", "", TRUE);
		$bPostBack = ew_IsHttpPost();
		$bValidate = TRUE;
		if ($bPostBack) {
			$this->OldPassword = ew_StripSlashes(@$_POST["opwd"]);
			$this->NewPassword = ew_StripSlashes(@$_POST["npwd"]);
			$this->ConfirmedPassword = ew_StripSlashes(@$_POST["cpwd"]);
			$bValidate = $this->ValidateForm($this->OldPassword, $this->NewPassword, $this->ConfirmedPassword);
			if (!$bValidate) {
				$this->setFailureMessage($gsFormError);
			}
		}
		if (MS_SHOW_CAPTCHA_ON_CHANGE_PASSWORD_PAGE == TRUE) {

		/*

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
		*/
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
		$bPwdUpdated = FALSE;
		if ($bPostBack && $bValidate) {

			// Setup variables
			$sUsername = $Security->CurrentUserName();
			if (IsPasswordReset())
				$sUsername = $_SESSION[EW_SESSION_USER_PROFILE_USER_NAME];
			if (IsPasswordExpired())
				$sUsername = $_SESSION[EW_SESSION_USER_PROFILE_USER_NAME];
			$sFilter = str_replace("%u", ew_AdjustSql($sUsername, EW_USER_TABLE_DBID), EW_USER_NAME_FILTER);

			// Set up filter (Sql Where Clause) and get Return SQL
			// SQL constructor in users class, usersinfo.php

			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			if ($rs = $UserTableConn->Execute($sSql)) {
				if (!$rs->EOF) {
					$rsold = $rs->fields;
					if (IsPasswordReset() || ew_ComparePassword($rsold['Password'], $this->OldPassword)) {
						$bValidPwd = TRUE;
						if (!IsPasswordReset())
							$bValidPwd = $this->User_ChangePassword($rsold, $sUsername, $this->OldPassword, $this->NewPassword);
						if ($bValidPwd) {
							$rsnew = array('Password' => $this->NewPassword); // Change Password
							$sEmail = $rsold['Email'];
							$rs->Close();
							$UserTableConn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
							$bValidPwd = $this->Update($rsnew);
							$UserTableConn->raiseErrorFn = '';
							if ($bValidPwd)
								$bPwdUpdated = TRUE;
						} else {
							$this->setFailureMessage($Language->Phrase("InvalidNewPassword"));
							$rs->Close();
						}
					} else {
						$this->setFailureMessage($Language->Phrase("InvalidPassword"));
					}
				} else {
					$rs->Close();
				}
			}
		}
		if ($bPwdUpdated) {
			if (@$sEmail <> "") {

				// Load Email Content
				$Email = new cEmail();
				$Email->Load(EW_EMAIL_CHANGEPWD_TEMPLATE);
				$Email->ReplaceSender(EW_SENDER_EMAIL); // Replace Sender
				$Email->ReplaceRecipient($sEmail); // Replace Recipient
				if (MS_SHOW_PLAIN_TEXT_PASSWORD==TRUE) {
					$Email->ReplaceContent('<!--$Password-->', $this->NewPassword);
				} else {
					$Email->ReplaceContent('<!--$Password-->', '********** (it is hidden)');
				}
				$Email->ReplaceSubject($Language->Phrase("SubjectChangePassword").' '.$Language->ProjectPhrase("BodyTitle"));
				$Args = array();
				$Args["rs"] = &$rsnew;
				$bEmailSent = FALSE;
				if ($this->Email_Sending($Email, $Args))
					$bEmailSent = $Email->Send();

				// Send email failed
				if (!$bEmailSent)
					$this->setFailureMessage($Email->SendErrDescription);
			}
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("PasswordChanged")); // Set up success message
			if (IsPasswordReset()) {
				$_SESSION[EW_SESSION_STATUS] = "";
				$_SESSION[EW_SESSION_USER_PROFILE_USER_NAME] = "";
			}

			// Update user profile and login again
			global $UserProfile;
			$UserProfile->LoadProfileFromDatabase($sUsername);
			$UserProfile->SetValue(EW_USER_PROFILE_LAST_PASSWORD_CHANGED_DATE, ew_StdCurrentDate());
			$UserProfile->SaveProfileToDatabase($sUsername);
			if (IsPasswordExpired()) {
				$_SESSION[EW_SESSION_USER_PROFILE_PASSWORD] = $this->NewPassword;
				$_SESSION[EW_SESSION_STATUS] = "loggingin";
				$this->Page_Terminate("login.php"); // Continue login process
			}
			$this->Page_Terminate("index.php"); // Exit page and clean up
		}
	}

	// Validate form
	function ValidateForm($opwd, $npwd, $cpwd) {
		global $Language, $gsFormError;

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Initialize form error message
		$gsFormError = "";
		if (!IsPasswordReset() && $opwd == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterOldPassword"));
		}
		if ($npwd == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterNewPassword"));
		}
		if ($npwd <> $cpwd) {
			ew_AddMessage($gsFormError, $Language->Phrase("MismatchPassword"));
		}
		if (MS_PASSWORD_POLICY_FROM_MASINO_CHANGEPWD == TRUE) { 

			// Begin of modification Strong Password Policies/Rules, by Masino Sinaga, June 12, 2012
			if (MS_PASSWORD_MUST_COMPLY_WITH_MIN_LENGTH==TRUE) {
				if( strlen($npwd) < MS_PASSWORD_MINIMUM_LENGTH ) {

					//$this->setFailureMessage(str_replace("%n", MS_PASSWORD_MINIMUM_LENGTH, $Language->Phrase("ErrorPassTooShort")));
					//$isError = TRUE;

					ew_AddMessage($gsFormError, str_replace("%n", MS_PASSWORD_MINIMUM_LENGTH, $Language->Phrase("ErrorPassTooShort")));
				}
			}
			if (MS_PASSWORD_MUST_COMPLY_WITH_MAX_LENGTH==TRUE) {
				if( strlen($npwd) > MS_PASSWORD_MAXIMUM_LENGTH ) {

					//$this->setFailureMessage(str_replace("%n", MS_PASSWORD_MAXIMUM_LENGTH, $Language->Phrase("ErrorPassTooLong")));
					//$isError = TRUE;

					ew_AddMessage($gsFormError, str_replace("%n", MS_PASSWORD_MAXIMUM_LENGTH, $Language->Phrase("ErrorPassTooLong")));
				}
			}
			if (MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_NUMBER==TRUE) {
				if( !preg_match("#[0-9]+#", $npwd) ) {

					//$this->setFailureMessage($Language->Phrase("ErrorPassDoesNotIncludeNumber"));
					//$isError = TRUE;

					ew_AddMessage($gsFormError, $Language->Phrase("ErrorPassDoesNotIncludeNumber"));
				}
			}
			if (MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_LETTER==TRUE) {
				if( !preg_match("#[a-z]+#", $npwd) ) {

					//$this->setFailureMessage($Language->Phrase("ErrorPassDoesNotIncludeLetter"));
					//$isError = TRUE;

					ew_AddMessage($gsFormError, $Language->Phrase("ErrorPassDoesNotIncludeLetter"));
				}
			}
			if (MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_CAPS==TRUE) {
				if( !preg_match("#[A-Z]+#", $npwd) ) {

					//$this->setFailureMessage($Language->Phrase("ErrorPassDoesNotIncludeCaps"));
					//$isError = TRUE;

					ew_AddMessage($gsFormError, $Language->Phrase("ErrorPassDoesNotIncludeCaps"));
				}
			}
			if (MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_SYMBOL==TRUE) {
				if( !preg_match("#\W+#", $npwd) ) {

					//$this->setFailureMessage($Language->Phrase("ErrorPassDoesNotIncludeSymbol"));
					//$isError = TRUE;

					ew_AddMessage($gsFormError, $Language->Phrase("ErrorPassDoesNotIncludeSymbol"));
				}
			}
			if (MS_PASSWORD_MUST_DIFFERENT_OLD_AND_NEW==TRUE) {
				if ($opwd==$npwd) {

					//$this->setFailureMessage($Language->Phrase("ErrorPassCouldNotBeSame"));
					//$isError = TRUE;

					ew_AddMessage($gsFormError, $Language->Phrase("ErrorPassCouldNotBeSame"));
				}
			}

			// End of modification Strong Password Policies/Rules, by Masino Sinaga, June 12, 2012
		} else {
		}

		// Return validate result
		$valid = ($gsFormError == "");

		// Call Form CustomValidate event
		$sFormCustomError = "";
		$valid = $valid && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $valid;
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

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// User ChangePassword event
	function User_ChangePassword(&$rs, $usr, $oldpwd, &$newpwd) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($changepwd)) $changepwd = new cchangepwd();

// Page init
$changepwd->Page_Init();

// Page main
$changepwd->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$changepwd->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<script type="text/javascript" src="phpjs/changepwd_dialog.js"></script>
<script type="text/javascript">
var fchangepwd = new ew_Form("fchangepwd");

// Extend form with Validate function
fchangepwd.Validate = function() {
	var $ = jQuery, fobj = this.Form, $npwd = $(fobj.npwd);
	if (!this.ValidateRequired)
		return true; // Ignore validation
<?php if (!IsPasswordReset()) { ?>
	if (!ew_HasValue(fobj.opwd))
		return this.OnError(fobj.opwd, ewLanguage.Phrase("EnterOldPassword"));
<?php } ?>
	if (!ew_HasValue(fobj.npwd))
		return this.OnError(fobj.npwd, ewLanguage.Phrase("EnterNewPassword"));
	if ($npwd.hasClass("ewPasswordStrength") && !$npwd.data("validated"))
		return this.OnError(fobj.npwd, ewLanguage.Phrase("PasswordTooSimple"));
	if (fobj.npwd.value != fobj.cpwd.value)
		return this.OnError(fobj.cpwd, ewLanguage.Phrase("MismatchPassword"));
<?php if (MS_SHOW_CAPTCHA_ON_CHANGE_PASSWORD_PAGE == TRUE) { ?>
		if (fobj.captcha && !ew_HasValue(fobj.captcha))
			return this.OnError(fobj.captcha, ewLanguage.Phrase("EnterValidateCode"));
<?php } ?>

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// Extend form with Form_CustomValidate function
fchangepwd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Requires js validation
<?php if (EW_CLIENT_VALIDATE) { ?>
fchangepwd.ValidateRequired = true;
<?php } else { ?>
fchangepwd.ValidateRequired = false;
<?php } ?>
</script>
<div class="ewToolbar">
<?php if (MS_SHOW_BREADCRUMBLINKS_ON_CHANGEPWD_PAGE) { ?>
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
<?php $changepwd->ShowPageHeader(); ?>
<?php
$changepwd->ShowMessage();
?>
<form name="fchangepwd" id="fchangepwd" class="form-horizontal ewForm ewChangepwdForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if (MS_CHANGEPWD_WINDOW_TYPE=="default" || MS_CHANGEPWD_WINDOW_TYPE=="") { ?>
<div class="col-sm-8 col-sm-offset-2">
<div class="panel <?php echo MS_CHANGEPWD_FORM_PANEL_TYPE; ?>">
<div class="panel-heading"><strong><?php echo $Language->Phrase("ChangePwd") ?></strong><?php if (@MS_SHOW_HELP_ONLINE) { ?> &nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a> <?php } ?></div>
<div class="panel-body">
<br>
<?php if ($changepwd->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $changepwd->Token ?>">
<?php } ?>
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<?php if (!IsPasswordReset()) { ?>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="opwd"><?php echo $Language->Phrase("OldPassword") ?></label>
		<div class="col-sm-8"><input type="password" name="opwd" id="opwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("OldPassword")) ?>"></div>
	</div>
<?php } ?>
	<?php if (MS_PASSWORD_POLICY_FROM_MASINO_CHANGEPWD == TRUE) { ?>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="npwd"><?php echo $Language->Phrase("NewPassword") ?></label>
		<div class="col-sm-8"><input type="password" name="npwd" id="npwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("NewPassword")) ?>" onkeyup="passwordStrength(this.value, cpwd.value)" value="<?php echo @$_POST["npwd"]; ?>">
			<div id="passwordDescription"><?php echo $Language->Phrase("empty"); ?></div>
			<div class="password-meter-bg">
			  <div id="passwordStrength" class="strength0"></div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="cpwd"><?php echo $Language->Phrase("ConfirmPassword") ?></label>
		<div class="col-sm-8"><input type="password" name="cpwd" id="cpwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("ConfirmPassword")) ?>" onkeyup="passwordConfirmation(npwd.value, this.value)" value="<?php echo @$_POST["cpwd"]; ?>"/>
			<div id="passconfDescription"><?php echo $Language->Phrase("match"); ?></div>
			<div class="password-meter-bg">        
			  <div id="passconfConfirmation" class="conf1"></div>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="npwd"><?php echo $Language->Phrase("NewPassword") ?></label>
		<div class="col-sm-8">
		<div class="input-group" id="ignpwd">
		<input type="password" data-password-strength="pst_npwd" data-password-generated="pgt_npwd" name="npwd" id="npwd" class="form-control ewControl ewPasswordStrength" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("ConfirmPassword")) ?>">
		<span class="input-group-btn">
			<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="npwd" data-password-confirm="cpwd" data-password-strength="pst_npwd" data-password-generated="pgt_npwd"><?php echo $Language->Phrase("GeneratePassword") ?></button>
		</span>
		</div>
		<span class="help-block" id="pgt_npwd" style="display: none;"></span>
		<div class="progress ewPasswordStrengthBar" id="pst_npwd" style="display: none;">
			<div class="progress-bar" role="progressbar"></div>
		</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="cpwd"><?php echo $Language->Phrase("ConfirmPassword") ?></label>
		<div class="col-sm-8">
		<input type="password" name="cpwd" id="cpwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("ConfirmPassword")) ?>">
		</div>
	</div>
	<?php } ?>
	<?php if (MS_SHOW_CAPTCHA_ON_CHANGE_PASSWORD_PAGE == TRUE) { ?>
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
			<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("ChangePwdBtn") ?></button>
		</div>
	</div>
</div>
<div class="panel-footer <?php echo MS_CHANGEPWD_FORM_PANEL_TYPE; ?>">
	<div>
	</div>
</div>
</div>
</div>
<?php } else { // Window type: popup ?>
<div id="msChangePwdDialog" class="modal fade">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">x</span></button><h4 class="modal-title"><?php echo $Language->Phrase("ChangePwd") ?><?php if (@MS_SHOW_HELP_ONLINE) { ?> &nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a> <?php } ?></h4></div>
<div class="modal-body">
<br>
<?php if ($changepwd->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $changepwd->Token ?>">
<?php } ?>
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<?php if (!IsPasswordReset()) { ?>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="opwd"><?php echo $Language->Phrase("OldPassword") ?></label>
		<div class="col-sm-8"><input type="password" name="opwd" id="opwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("OldPassword")) ?>"></div>
	</div>
<?php } ?>
	<?php if (MS_PASSWORD_POLICY_FROM_MASINO_CHANGEPWD == TRUE) { ?>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="npwd"><?php echo $Language->Phrase("NewPassword") ?></label>
		<div class="col-sm-8"><input type="password" name="npwd" id="npwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("NewPassword")) ?>" onkeyup="passwordStrength(this.value, cpwd.value)" value="<?php echo @$_POST["npwd"]; ?>">
			<div id="passwordDescription"><?php echo $Language->Phrase("empty"); ?></div>
			<div class="password-meter-bg">
			  <div id="passwordStrength" class="strength0"></div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="cpwd"><?php echo $Language->Phrase("ConfirmPassword") ?></label>
		<div class="col-sm-8"><input type="password" name="cpwd" id="cpwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("ConfirmPassword")) ?>" onkeyup="passwordConfirmation(npwd.value, this.value)" value="<?php echo @$_POST["cpwd"]; ?>"/>
			<div id="passconfDescription"><?php echo $Language->Phrase("match"); ?></div>
			<div class="password-meter-bg">        
			  <div id="passconfConfirmation" class="conf1"></div>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="npwd"><?php echo $Language->Phrase("NewPassword") ?></label>
		<div class="col-sm-8">
		<div class="input-group" id="ignpwd">
		<input type="password" data-password-strength="pst_npwd" data-password-generated="pgt_npwd" name="npwd" id="npwd" class="form-control ewControl ewPasswordStrength" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("ConfirmPassword")) ?>">
		<span class="input-group-btn">
			<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="npwd" data-password-confirm="cpwd" data-password-strength="pst_npwd" data-password-generated="pgt_npwd"><?php echo $Language->Phrase("GeneratePassword") ?></button>
		</span>
		</div>
		<span class="help-block" id="pgt_npwd" style="display: none;"></span>
		<div class="progress ewPasswordStrengthBar" id="pst_npwd" style="display: none;">
			<div class="progress-bar" role="progressbar"></div>
		</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label ewLabel" for="cpwd"><?php echo $Language->Phrase("ConfirmPassword") ?></label>
		<div class="col-sm-8">
		<input type="password" name="cpwd" id="cpwd" class="form-control ewControl" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("ConfirmPassword")) ?>">
		</div>
	</div>
	<?php } ?>
	<?php if (MS_SHOW_CAPTCHA_ON_CHANGE_PASSWORD_PAGE == TRUE) { ?>
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
			<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("ChangePwdBtn") ?></button>
		</div>
	</div>
	</div>
<div class="modal-footer">
	<div></div>
</div>
</div>
</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fchangepwd.Init();
$(document).ready(function(){
<?php if (MS_CHANGEPWD_WINDOW_TYPE=="popup") { ?>
  msChangePwdDialogShow();
  $('#msChangePwdDialog').on('shown.bs.modal', function () {
    $('#opwd').focus();
  });
<?php } else { ?>
  $('#opwd').focus();
<?php } ?>
<?php if (MS_TERMS_AND_CONDITION_CHECKBOX_ON_CHANGEPWD_PAGE == TRUE) { ?>
  if ($('#chktac').attr('checked')) {
	$('#btnsubmit').removeAttr('disabled');
  } else {
	$('#btnsubmit').attr('disabled', 'disabled');
  }
  $("#chktac").click(function() {
    var checked_status = this.checked;
    if (checked_status == true) {
	  $('#btnsubmit').removeAttr('disabled');
	} else {
	  $('#btnsubmit').attr('disabled', 'disabled');
	}
  });
<?php } ?>
});
</script>
<?php
$changepwd->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php // Begin of modification Password Strength Meter, by Masino Sinaga, June 9, 2012 ?>
<style>
.password-meter{position:relative;width:180px}.password-meter-message{text-align:right;font-weight:bold;color:#676767}.password-meter-bg,.password-meter-bar{height:5px;width:100px}.password-meter-bg{top:8px;background:#ccc}#passconfConfirmation{height:5px;display:block;float:left}.conf0{width:50px;background:red}.conf1{background:#256800;width:100px}#passwordStrength{height:5px;display:block;float:left}.strength0{background:#ccc;width:100px}.strength1{background:red;width:20px}.strength2{background:#ff5f5f;width:40px}.strength3{background:#56e500;width:60px}.strength4{background:#4dcd00;width:80px}.strength5{background:#399800;width:90px}.strength6{background:#256800;width:100px}
</style>
<?php // End of modification Password Strength Meter, by Masino Sinaga, June 9, 2012 ?>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fchangepwd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
var password = document.getElementById("npwd").value;
var password2 = document.getElementById("cpwd").value;
passwordStrength(password, password2);
$('input[id=opwd]').val('');
$("#opwd").focus();
});
</script>
<script type="text/javascript">

function passwordConfirmation(pass1, pass2)
{
    var desc = new Array();
    desc[0] = "<?php echo $Language->Phrase("mismatch"); ?>";
    desc[1] = "<?php echo $Language->Phrase("match"); ?>";

    // var score = 0;
    if (pass1 != pass2) {
      score = 0;  
    } else {
      score = 1;
    }
     document.getElementById("passconfDescription").innerHTML = desc[score];
     document.getElementById("passconfConfirmation").className = "conf" + score;
}

function passwordStrength(password, password2)
{
    var desc = new Array();
    desc[0] = "<?php echo $Language->Phrase("empty"); ?>";
    desc[1] = "<?php echo $Language->Phrase("veryweak"); ?>";
    desc[2] = "<?php echo $Language->Phrase("weak"); ?>";
    desc[3] = "<?php echo $Language->Phrase("better"); ?>";
    desc[4] = "<?php echo $Language->Phrase("good"); ?>";
    desc[5] = "<?php echo $Language->Phrase("strong"); ?>";
    desc[6] = "<?php echo $Language->Phrase("strongest"); ?>";
    var descc = new Array();
    descc[0] = "<?php echo $Language->Phrase("mismatch"); ?>";
    descc[1] = "<?php echo $Language->Phrase("match"); ?>";
    var score = 1;

    //if password is empty, reset the score
    if (password.length == 0) score=0;

    //if password bigger than 6 give 1 point
    if (password.length > 6) score++;

    //if password has both lower and uppercase characters give 1 point
    if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

    //if password has at least one number give 1 point
    if (password.match(/\d+/)) score++;

    //if password has at least one special caracther give 1 point
    if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;

    //if password bigger than 12 give another 1 point
    if (password.length > 12) score++;
     document.getElementById("passwordDescription").innerHTML = desc[score];
     document.getElementById("passwordStrength").className = "strength" + score;
    var scorec = 0;
    if (password != password2) {
      scorec = 0;  
    } else {
      scorec = 1;
    }
     document.getElementById("passconfDescription").innerHTML = descc[scorec];
     document.getElementById("passconfConfirmation").className = "conf" + scorec;
}
</script>
<?php include_once "footer.php" ?>
<?php
$changepwd->Page_Terminate();
?>
