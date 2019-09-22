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

$forgotpwd = NULL; // Initialize page object first

class cforgotpwd extends cusers {

	// Page ID
	var $PageID = 'forgotpwd';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Page object name
	var $PageObjName = 'forgotpwd';

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
			define("EW_PAGE_ID", 'forgotpwd', TRUE);

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
	var $Email = "";
	var $Username = ""; // added by Masino Sinaga, April 21, 2014
	var $EmailOrUsername = ""; // added by Masino Sinaga, April 22, 2014
	var $Action = "";
	var $ActivateCode = "";

	//
	// Page main
	//
	function Page_Main() {
		global $UserTableConn, $Language, $gsFormError;
		global $Breadcrumb;
		$Breadcrumb = new cBreadcrumb;
		$Breadcrumb->Add("forgotpwd", "RequestPwdPage", ew_CurrentUrl(), "", "", TRUE);
		$bPostBack = ew_IsHttpPost();
		$bValidEmail = FALSE;
		if (MS_KNOWN_FIELD_OPTIONS=="Username" || MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") {
			$this->Username = @$_POST['username'];
		}
		if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername" || MS_KNOWN_FIELD_OPTIONS=="") {
			$this->Email = @$_POST['email'];
		}
		if ($bPostBack) {

			// Setup variables
			if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="") {
				$this->Email = $_POST["email"];
				$this->Username = @$_POST['username'];
				$bValidEmail = $this->ValidateForm($this->Email);
				if ($bValidEmail) {
					if (EW_ENCRYPTED_PASSWORD)
						$this->Action = "reset"; // Prompt user to change password
					else
						$this->Action = "confirm"; // Send password directly if not MD5
					$this->ActivateCode = ew_Encrypt($this->Email);
				} else {
					$this->setFailureMessage($gsFormError);
				}
			}
			if (MS_KNOWN_FIELD_OPTIONS=="Username") {
				$this->Username = @$_POST['username'];
				$bValidEmail = true;
				$sEmailUser = "";
				$sFilterUsername = str_replace("%u", ew_AdjustSql($this->Username), EW_USER_NAME_FILTER);
				$sSqlUserEmail = "SELECT `Email` FROM ".EW_USER_TABLE." WHERE ".$sFilterUsername;

				//echo $sSqlUserEmail;
				$rsUserEmail = ew_Execute($sSqlUserEmail);
				if ($rsUserEmail && $rsUserEmail->RecordCount() > 0) {
					$sEmailUser = $rsUserEmail->fields("Email");

					//echo $sEmailUser;
					$this->Email = $sEmailUser;
					$bValidEmail = $this->ValidateForm($this->Email);
					if ($bValidEmail) {
						if (EW_ENCRYPTED_PASSWORD)
							$this->Action = "reset"; // Prompt user to change password
						else
							$this->Action = "confirm"; // Send password directly if not MD5
						$this->ActivateCode = ew_Encrypt($this->Username);
					} else {
						$this->setFailureMessage($gsFormError);
					}
				} else {
					$this->setFailureMessage($Language->Phrase("InvalidParameter"));
				}
			}
			if (MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") {
				if (isset($_POST['EmailOrUsername'])) {
					if ($_POST['EmailOrUsername'] == "optEmail") {
						$this->Email = $_POST["email"];
						$this->Username = @$_POST['username'];
						$bValidEmail = $this->ValidateForm($this->Email);
						if ($bValidEmail) {
							if (EW_ENCRYPTED_PASSWORD)
								$this->Action = "reset"; // Prompt user to change password
							else
								$this->Action = "confirm"; // Send password directly if not MD5
							$this->ActivateCode = ew_Encrypt($this->Email);
						} else {
							$this->setFailureMessage($gsFormError);
						}
					} elseif ($_POST['EmailOrUsername'] == "optUsername") {
						$this->Username = @$_POST['username'];
						$bValidEmail = true;
						$sEmailUser = "";
						$sFilterUsername = str_replace("%u", ew_AdjustSql($this->Username), EW_USER_NAME_FILTER);
						$sSqlUserEmail = "SELECT `Email` FROM ".EW_USER_TABLE." WHERE ".$sFilterUsername;

						//echo $sSqlUserEmail;
						$rsUserEmail = ew_Execute($sSqlUserEmail);
						if ($rsUserEmail && $rsUserEmail->RecordCount() > 0) {
							$sEmailUser = $rsUserEmail->fields("Email");

							//echo $sEmailUser;
							$this->Email = $sEmailUser;
							$bValidEmail = $this->ValidateForm($this->Email);
							if ($bValidEmail) {
								if (EW_ENCRYPTED_PASSWORD)
									$this->Action = "reset"; // Prompt user to change password
								else
									$this->Action = "confirm"; // Send password directly if not MD5
								$this->ActivateCode = ew_Encrypt($this->Username);
							} else {
								$this->setFailureMessage($gsFormError);
							}
						} else {
							$this->setFailureMessage($Language->Phrase("InvalidParameter"));
						}
					}
				}
			}

		// Handle email activation
		} elseif (@$_GET["action"] <> "") {
			$this->Action = $_GET["action"];
			$this->Email = @$_GET["email"];
			$this->Username = @$_GET["username"];
			$this->ActivateCode = @$_GET["code"];
			if ($this->Email <> "") {
				if ($this->Email <> ew_Decrypt($this->ActivateCode) && strtolower($this->Action) <> "confirm" && strtolower($this->Action) == "reset") { // Email activation
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("ActivateFailed")); // Set activate failed message
					$this->Page_Terminate("login.php"); // Go to login page
				}
				if (strtolower($this->Action) == "reset")
					$this->Action = "resetpassword";
			}
			if ($this->Username <> "") {
				if ($this->Username <> ew_Decrypt($this->ActivateCode) && strtolower($this->Action) <> "confirm" && strtolower($this->Action) == "reset") { // Email activation
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("ActivateFailed")); // Set activate failed message
					$this->Page_Terminate("login.php"); // Go to login page
				}
				$sEmailUser = "";
				$sFilterUsername = str_replace("%u", ew_AdjustSql($this->Username), EW_USER_NAME_FILTER);
				$sSqlUserEmail = "SELECT `Email` FROM ".EW_USER_TABLE." WHERE ".$sFilterUsername;
				$rsUserEmail = ew_Execute($sSqlUserEmail);
				if ($rsUserEmail && $rsUserEmail->RecordCount() > 0) {
					$sEmailUser = $rsUserEmail->fields("Email");
					$this->Email = $sEmailUser;
				}
				if (strtolower($this->Action) == "reset")
					$this->Action = "resetpassword";
			}
		}
		if (MS_SHOW_CAPTCHA_ON_FORGOT_PASSWORD_PAGE == TRUE) {

		/*

		// CAPTCHA checking
		if (ew_IsHttpPost()) {
			$this->captcha = @$_POST["captcha"];
			if (!$this->ValidateCaptcha()) { // CAPTCHA unmatched
				$this->setFailureMessage($Language->Phrase("EnterValidateCode")); // Set message
				$bValidEmail = FALSE;
				$this->Action = "";
			}
		}
		if (!$bValidEmail) {
			$this->ResetCaptcha();
		}
		*/

		// CAPTCHA checking
		if (ew_IsHttpPost()) {
			$this->captcha = @$_POST["captcha"];
			if (!$this->ValidateCaptcha()) { // CAPTCHA unmatched
				$this->setFailureMessage($Language->Phrase("EnterValidateCode")); // Set message
				$bValidate = FALSE;
				$this->Action = "";
			}
		}
		if (!$bValidEmail) {
			$this->ResetCaptcha();
		}
		}
		if ($this->Action <> "") {
			$bEmailSent = FALSE;

			// Set up filter (SQL WHERE clause) and get Return SQL
			// SQL constructor in users class, usersinfo.php
			//  $sFilter = str_replace("%e", ew_AdjustSql($this->Email, EW_USER_TABLE_DBID), EW_USER_EMAIL_FILTER);

			if (@$_GET["email"] <> "") {
				$sFilter = str_replace("%e", ew_AdjustSql($this->Email, EW_USER_TABLE_DBID), EW_USER_EMAIL_FILTER);
			} elseif (@$_GET["username"] <> "") {
				$sFilter = str_replace("%u", ew_AdjustSql($this->Username, EW_USER_TABLE_DBID), EW_USER_NAME_FILTER);
			} else {
				$sFilter = str_replace("%e", ew_AdjustSql($this->Email, EW_USER_TABLE_DBID), EW_USER_EMAIL_FILTER);
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			if ($RsUser = $UserTableConn->Execute($sSql)) {
				if (!$RsUser->EOF) {
					$user_name = $RsUser->fields("Username"); // <-- // Saving the date and time of Reset Password, by Masino Sinaga, October 7, 2013
					$rsold = $RsUser->fields;
					$bValidEmail = TRUE;

					// Call User Recover Password event
					$bValidEmail = $this->User_RecoverPassword($rsold);
					if ($bValidEmail) {
						$sUserName = $rsold['Username'];
						$sPassword = $rsold['Password'];

						/*
						if (EW_ENCRYPTED_PASSWORD) {
							if (strtolower($this->Action) == "confirm") {
								$sPassword = substr($sPassword, 0, 16); // Use first 16 characters only
								$rsnew = array('Password' => $sPassword); // Reset the password
								$this->Update($rsnew);

								// Begin of modification saving the date and time of Reset Password, by Masino Sinaga, October 7, 2013
								$UserProfile = new cUserProfile();
								$UserProfile->LoadProfileFromDatabase($user_name);
								$UserProfile->SetValue(EW_USER_PROFILE_LAST_PASSWORD_CHANGED_DATE, ew_StdCurrentDate());
								$UserProfile->SaveProfileToDatabase($user_name);

								// End of modification saving the date and time of Reset Password, by Masino Sinaga, October 7, 2013
							}
						} else {
							if (MS_SEND_PASSWORD_DIRECTLY_IF_NOT_ENCRYPTED) {
								$this->Action = "confirm"; // Send password directly if not MD5
							} else {
								if (strtolower($this->Action) == "confirm") {
									$sPassword = substr($sPassword, 0, 16); // Use first 16 characters only
									$rsnew = array('Password' => $sPassword); // Reset the password
									$this->Update($rsnew);

									// Begin of modification saving the date and time of Reset Password, by Masino Sinaga, October 7, 2013
									$UserProfile = new cUserProfile();
									$UserProfile->LoadProfileFromDatabase($user_name);
									$UserProfile->SetValue(EW_USER_PROFILE_LAST_PASSWORD_CHANGED_DATE, ew_StdCurrentDate());
									$UserProfile->SaveProfileToDatabase($user_name);

									// End of modification saving the date and time of Reset Password, by Masino Sinaga, October 7, 2013
								}
							}
						}
						*/
					}
				} else {
					$bValidEmail = FALSE;
					$this->setFailureMessage($Language->Phrase("InvalidEmail"));
				}
				$RsUser->Close();

				/*
				if ($bValidEmail) {
					$Email = new cEmail();
					if (strtolower($this->Action) == "confirm") {
						$Email->Load('phptxt/forgotpwd-'.$GLOBALS["Language"]->LanguageId.'.txt');
						$Email->ReplaceSubject($Language->Phrase("SubjectSendNewPassword").' '.$Language->ProjectPhrase("BodyTitle"));
						$Email->ReplaceContent('<!--$Password-->', $sPassword);
					} else {
						$Email->Load('phptxt/resetpwd-'.$GLOBALS["Language"]->LanguageId.'.txt');
						$sActivateLink = ew_FullUrl() . "?action=confirm";
						if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="") {
							$sActivateLink .= "&email=" . $this->Email;
						} elseif (MS_KNOWN_FIELD_OPTIONS=="Username") {
							$sActivateLink .= "&username=" . $this->Username;
						} elseif (MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") {
							if (isset($_POST['EmailOrUsername'])) {
								if ($_POST['EmailOrUsername'] == "optEmail") {
									$sActivateLink .= "&email=" . $this->Email;
								} elseif ($_POST['EmailOrUsername'] == "optUsername") {
									$sActivateLink .= "&username=" . $this->Username;
								}
							}
						}
						$sActivateLink .= "&code=" . $this->ActivateCode;
						$Email->ReplaceSubject($Language->Phrase("SubjectRequestPasswordConfirmation").' '.$Language->ProjectPhrase("BodyTitle"));
						$Email->ReplaceContent('<!--$ActivateLink-->', $sActivateLink);
					}
					$Email->ReplaceSender(EW_SENDER_EMAIL); // Replace Sender
					$Email->ReplaceRecipient($this->Email); // Replace Recipient
					$Email->ReplaceContent('<!--$UserName-->', $sUserName);
					$Email->Charset = EW_EMAIL_CHARSET;
					$Args = array();

					// if (EW_ENCRYPTED_PASSWORD && strtolower($this->Action) == "confirm") $Args["rs"] = &$rsnew; // Either encrypted or not, confirmation is always needed!
					if (strtolower($this->Action) == "confirm") $Args["rs"] = &$rsnew;
					if ($this->Email_Sending($Email, $Args))
						$bEmailSent = $Email->Send();
				}
				$RsUser->Close();
				*/
				if ($bValidEmail) {
					if (strtolower($this->Action) == "resetpassword") { // Reset password
						$_SESSION[EW_SESSION_USER_PROFILE_USER_NAME] = $sUserName; // Save login user name
						$_SESSION[EW_SESSION_STATUS] = "passwordreset";
						$this->Page_Terminate("changepwd.php");
					} else {
						$Email = new cEmail();
						if (strtolower($this->Action) == "confirm") {
							$Email->Load(EW_EMAIL_FORGOTPWD_TEMPLATE);
							$Email->ReplaceContent('<!--$Password-->', $sPassword);
						} else {
							$Email->Load(EW_EMAIL_RESETPWD_TEMPLATE);

							/*
							$sActivateLink = ew_FullUrl() . "?action=reset";
							$sActivateLink .= "&email=" . $this->Email;
							$sActivateLink .= "&code=" . $this->ActivateCode;
							$Email->ReplaceContent('<!--$ActivateLink-->', $sActivateLink);
							*/

							// $sActivateLink = ew_FullUrl() . "?action=confirm"; // <-- will trigger second email to be sent that contains new password, do not use it!
							$sActivateLink = ew_FullUrl() . "?action=reset"; // <-- will trigger change password page displayed, so user will change his/her password immediately
							if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="") {
								$sActivateLink .= "&email=" . $this->Email;
							} elseif (MS_KNOWN_FIELD_OPTIONS=="Username") {
								$sActivateLink .= "&username=" . $this->Username;
							} elseif (MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") {
								if (isset($_POST['EmailOrUsername'])) {
									if ($_POST['EmailOrUsername'] == "optEmail") {
										$sActivateLink .= "&email=" . $this->Email;
									} elseif ($_POST['EmailOrUsername'] == "optUsername") {
										$sActivateLink .= "&username=" . $this->Username;
									}
								}
							}
							$sActivateLink .= "&code=" . $this->ActivateCode;
							$Email->ReplaceSubject($Language->Phrase("SubjectRequestPasswordConfirmation").' '.$Language->ProjectPhrase("BodyTitle"));

							// PasswordRequest
							$Email->ReplaceContent('<!--$ActivateLink-->', $sActivateLink);
						}
						$Email->ReplaceSender(EW_SENDER_EMAIL); // Replace Sender
						$Email->ReplaceRecipient($this->Email); // Replace Recipient
						$Email->ReplaceContent('<!--$UserName-->', $sUserName);
						$Args = array();
						if (EW_ENCRYPTED_PASSWORD && strtolower($this->Action) == "confirm") $Args["rs"] = &$rsnew;
						if ($this->Email_Sending($Email, $Args))
							$bEmailSent = $Email->Send();
					}
				}
			}
			if ($bEmailSent) {
				if ($this->getSuccessMessage() == "")
					if (strtolower($this->Action) == "confirm") {
						$this->setSuccessMessage($Language->Phrase("PwdEmailSent")); // Set up success message

						// Begin of modification Log Reset Forgot Password into Audit Trail, by Masino Sinaga, June 6, 2012
						ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), CurrentUserID()." - ".$sUsername, $Language->Phrase("LogResetPassword"), ew_CurrentUserIP(), "", "", "", "");

						// End of modification Log Reset Forgot Password into Audit Trail, by Masino Sinaga, June 6, 2012
					} else {
						$this->setSuccessMessage($Language->Phrase("ResetPwdEmailSent")); // Set up success message
					}
				$this->Page_Terminate("login.php"); // Return to login page
			} elseif ($bValidEmail) {
				$this->setFailureMessage($Email->SendErrDescription); // Set up error message
			}
		}
	}

	//
	// Validate form
	//
	function ValidateForm($email) {
		global $gsFormError, $Language;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="") {
			if ($email == "") {
				ew_AddMessage($gsFormError, $Language->Phrase("EnterValidEmail"));
			}
			if (!ew_CheckEmail($email)) {
				ew_AddMessage($gsFormError, $Language->Phrase("EnterValidEmail"));
			}
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

	// User RecoverPassword event
	function User_RecoverPassword(&$rs) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($forgotpwd)) $forgotpwd = new cforgotpwd();

// Page init
$forgotpwd->Page_Init();

// Page main
$forgotpwd->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$forgotpwd->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<script type="text/javascript" src="phpjs/forgotpwd_dialog.js"></script>
<script type="text/javascript">
var fforgotpwd = new ew_Form("fforgotpwd");

// Extend page with Validate function
fforgotpwd.Validate = function()
{
	var fobj = this.Form;
	if (!this.ValidateRequired)
		return true; // Ignore validation
<?php if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="") { ?>
	if  (!ew_HasValue(fobj.email))
		return this.OnError(fobj.email, ewLanguage.Phrase("EnterValidEmail"));
	if  (!ew_CheckEmail(fobj.email.value))
		return this.OnError(fobj.email, ewLanguage.Phrase("EnterValidEmail"));
<?php } ?>
<?php if (MS_KNOWN_FIELD_OPTIONS=="Username") { ?>
	if  (!ew_HasValue(fobj.username))
		return this.OnError(fobj.username, ewLanguage.Phrase("EnterUsername"));
<?php } ?>
<?php 	if (MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") { ?>
				if (document.getElementById('optEmail').checked) {
					if  (!ew_HasValue(fobj.email))
						return this.OnError(fobj.email, ewLanguage.Phrase("EnterValidEmail"));
					if  (!ew_CheckEmail(fobj.email.value))
						return this.OnError(fobj.email, ewLanguage.Phrase("EnterValidEmail"));
				} else if (document.getElementById('optUsername').checked) {
					if  (!ew_HasValue(fobj.username))
						return this.OnError(fobj.username, ewLanguage.Phrase("EnterUsername"));
				}
<?php	}  ?>
		if (fobj.captcha && !ew_HasValue(fobj.captcha))
			return this.OnError(fobj.captcha, ewLanguage.Phrase("EnterValidateCode"));

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// Extend form with Form_CustomValidate function
fforgotpwd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Requires js validation
<?php if (EW_CLIENT_VALIDATE) { ?>
fforgotpwd.ValidateRequired = true;
<?php } else { ?>
fforgotpwd.ValidateRequired = false;
<?php } ?>
</script>
<div class="ewToolbar">
<?php if (MS_SHOW_BREADCRUMBLINKS_ON_FORGOTPWD_PAGE) { ?>
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
<?php $forgotpwd->ShowPageHeader(); ?>
<?php
$forgotpwd->ShowMessage();
?>
<form name="fforgotpwd" id="fforgotpwd" class="form-horizontal ewForm ewForgotpwdForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if (MS_FORGOTPWD_WINDOW_TYPE=="default" || MS_FORGOTPWD_WINDOW_TYPE=="") { ?>
<div class="col-sm-8 col-sm-offset-2">
<div class="panel <?php echo MS_FORGOTPWD_FORM_PANEL_TYPE; ?>">
<div class="panel-heading"><strong><?php echo $Language->Phrase("ForgotPwd") ?></strong><?php if (@MS_SHOW_HELP_ONLINE) { ?> &nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a> <?php } ?></div>
<div class="panel-body">
<br>
<?php } else { ?>
<div id="msForgotPwdDialog" class="modal fade">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">x</span></button><h4 class="modal-title"><?php echo $Language->Phrase("ForgotPwd") ?><?php if (@MS_SHOW_HELP_ONLINE) { ?> &nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a> <?php } ?></h4></div>
<div class="modal-body">
<br>
<?php } ?>
<?php if ($forgotpwd->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $forgotpwd->Token ?>">
<?php } ?>
<?php
	if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="") {
?>
	<div class="form-group" id="control-email">
		<label class="col-sm-4 control-label ewLabel" for="email"><?php echo $Language->Phrase("UserEmail") ?></label>
		<div class="col-sm-8"><input type="text" name="email" id="email" class="form-control ewControl" value="<?php ew_HtmlEncode($forgotpwd->Email) ?>" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("UserEmail")) ?>"></div>
	</div>
<?php
	}
?>
<?php
	if (MS_KNOWN_FIELD_OPTIONS=="Username") {
?>
	<div class="form-group" id="control-username">
		<label class="col-sm-4 control-label ewLabel" for="username"><?php echo $Language->Phrase("UserName") ?></label>
		<div class="col-sm-8"><input type="text" name="username" id="username" class="form-control ewControl" value="<?php ew_HtmlEncode($forgotpwd->Username) ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("UserName")) ?>"></div>
	</div>
<?php
	}
?>
<?php
	if (MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") {
?>	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<label class="radio-inline ewRadio" style="white-space: nowrap;"><input type="radio" name="EmailOrUsername" id="optEmail" value="optEmail" checked="checked">Email</label>&nbsp;&nbsp;<label class="radio-inline ewRadio" style="white-space: nowrap;"><input type="radio" name="EmailOrUsername" id="optUsername" value="optUsername">Username</label>
		</div>
	</div>
	<div class="form-group" id="control-email">
		<label class="col-sm-4 control-label ewLabel" for="email"><?php echo $Language->Phrase("UserEmail") ?></label>
		<div class="col-sm-8"><input type="text" name="email" id="email" class="form-control ewControl" value="<?php ew_HtmlEncode($forgotpwd->Email) ?>" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("UserEmail")) ?>"></div>
	</div>
	<div class="form-group" id="control-username">
		<label class="col-sm-4 control-label ewLabel" for="username"><?php echo $Language->Phrase("UserName") ?></label>
		<div class="col-sm-8"><input type="text" name="username" id="username" class="form-control ewControl" value="<?php ew_HtmlEncode($forgotpwd->Username) ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("UserName")) ?>"></div>
	</div>
<?php
	}
?>
<?php if (MS_SHOW_CAPTCHA_ON_FORGOT_PASSWORD_PAGE == TRUE) { ?>
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
			<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SendPwd") ?></button>
			<button class="btn btn-danger ewButton" name="btnreset" id="btnreset" type="reset"><?php echo $Language->Phrase("Reset") ?></button>
		</div>
	</div>
</div>
<?php if (MS_FORGOTPWD_WINDOW_TYPE=="default" || MS_FORGOTPWD_WINDOW_TYPE=="") { ?>
<div class="panel-footer <?php echo MS_FORGOTPWD_FORM_PANEL_TYPE; ?>">
	<div>
		<a class="ewLink ewLinkSeparator" href="login.php"><?php echo $Language->Phrase("Login") ?></a>
		<?php if (@MS_USER_REGISTRATION) { ?>
		<a class="ewLink ewLinkSeparator" href="register.php"><?php echo $Language->Phrase("Register") ?></a>
		<?php } ?>
	</div>
</div>
</div>
</div>
<?php } else { ?>
<div class="modal-footer">
	<div class="pull-left">
		<a class="ewLink ewLinkSeparator" href="login.php"><?php echo $Language->Phrase("Login") ?></a>
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
fforgotpwd.Init();
$(document).ready(function(){
<?php if (MS_FORGOTPWD_WINDOW_TYPE=="popup") { ?>
  msForgotPwdDialogShow();
  $('#msForgotPwdDialog').on('shown.bs.modal', function () {
  <?php if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") { ?>
    $("#email").focus();
  <?php } else { ?>
    $("#username").focus();
  <?php } ?>
  });
<?php } else { ?>
<?php if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") { ?>
  $("#email").focus();
<?php } else { ?>
  $("#username").focus();
<?php } ?>
<?php } ?>
});
</script>
<script type="text/javascript">

// Startup script from extension
<?php
	if (MS_KNOWN_FIELD_OPTIONS=="EmailOrUsername") {
?>	
$(document).ready(function(){
	if($('input[name=EmailOrUsername]:radio:checked').val()=="optEmail"){
		$("#control-username").hide();
		$("#control-email").show();
		$('#email').focus();
	} else if($('input[name=EmailOrUsername]:radio:checked').val()=="optUsername"){
		$("#control-email").hide();
		$("#control-username").show();
		$('#username').focus();
	}
    $('input[type="radio"]').click(function(){
		if($(this).attr("value")=="optEmail"){
			$("#control-username").hide();
			$("#control-email").show();
			$('#email').focus();
		} else if($(this).attr("value")=="optUsername"){
			$("#control-email").hide();
			$("#control-username").show();
			$('#username').focus();
		}
    });
});
<?php
	}
?>
</script>
<?php
$forgotpwd->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$forgotpwd->Page_Terminate();
?>
