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

$register = NULL; // Initialize page object first

class cregister extends cusers {

	// Page ID
	var $PageID = 'register';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Page object name
	var $PageObjName = 'register';

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
		if (!isset($GLOBALS["users"])) $GLOBALS["users"] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'register', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

// Begin of modification Disable/Enable Registration Page, by Masino Sinaga, May 14, 2012
        if (MS_USER_REGISTRATION==FALSE && $Security->IsAdmin()==FALSE) {    
            header("Location: login.php");  
        }

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
	var $FormClassName = "form-horizontal ewForm ewRegisterForm";

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

	//
	// Page main
	//
	function Page_Main() {
		global $UserTableConn, $Security, $Language, $gsFormError, $objForm, $UserProfile;  // $UserProfile added by Masino Sinaga, November 6, 2011;
		global $Breadcrumb;

		// Set up Breadcrumb
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("register", "RegisterPage", $url, "", "", TRUE); // v11.0.4
		$bUserExists = FALSE;
		if (@$_POST["a_register"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_register"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}

			// Check the password strength
			if (!$this->CheckPasswordStrength() && $this->CurrentAction != "I") {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {

			// $this->CurrentAction = "I"; // Display blank record // in order to display Terms and Condition page as the initial page.
			$this->LoadDefaultValues(); // Load default values
		}
		if (MS_SHOW_CAPTCHA_ON_REGISTRATION_PAGE == TRUE) { 

		/*

		// CAPTCHA checking
		if ($this->CurrentAction == "I" || $this->CurrentAction == "C") {
			$this->ResetCaptcha();
		} elseif (ew_IsHttpPost()) {
			$objForm->Index = -1;
			$this->captcha = $objForm->GetValue("captcha");
			if (!$this->ValidateCaptcha()) { // CAPTCHA unmatched
				$this->setFailureMessage($Language->Phrase("EnterValidateCode"));
				$this->CurrentAction = "I"; // Reset action, do not insert
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
			} else {
				if ($this->CurrentAction == "A")
					$this->ResetCaptcha();
			}
		}
		*/

		// CAPTCHA checking
		if ($this->CurrentAction <> "I" && $this->CurrentAction <> "C") {
			if ( (($this->CurrentAction == "F") || ($this->CurrentAction == "I") || ($this->CurrentAction == "A") || ($this->CurrentAction == "X")) && (MS_SHOW_CAPTCHA_ON_REGISTRATION_PAGE == TRUE) ) {
				$objForm->Index = -1;
				$this->captcha = $objForm->GetValue("captcha");
				if (!$this->ValidateCaptcha()) { // CAPTCHA unmatched
					$this->setFailureMessage($Language->Phrase("EnterValidateCode"));
					$this->CurrentAction = "I"; // Reset action, do not insert
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values
				} else {
					if ($this->CurrentAction == "A")
						$this->ResetCaptcha();
				}
			}
		} elseif ($this->CurrentAction == "I" || $this->CurrentAction == "C") {
			$this->ResetCaptcha();
		}
		}

		// Handle email activation
		if (@$_GET["action"] <> "") {
			$sAction = $_GET["action"];
			$sEmail = @$_GET["email"];
			$sCode = @$_GET["token"];
			@list($sApprovalCode, $sUsr, $sPwd) = explode(",", $sCode, 3);
			$sApprovalCode = ew_Decrypt($sApprovalCode);
			$sUsr = ew_Decrypt($sUsr);
			$sPwd = ew_Decrypt($sPwd);
			if ($sEmail == $sApprovalCode) {
				if (strtolower($sAction) == "confirm") { // Email activation
					if ($this->ActivateEmail($sEmail)) { // Activate this email
						if ($this->getSuccessMessage() == "")
							$this->setSuccessMessage($Language->Phrase("ActivateAccount")); // Set up message acount activated
						$this->Page_Terminate("login.php"); // Go to login page
					}
				}
			}
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("ActivateFailed")); // Set activate failed message
			$this->Page_Terminate("login.php"); // Go to login page
		}
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add

				// Check for duplicate User ID
				$sFilter = str_replace("%u", ew_AdjustSql($this->Username->CurrentValue), EW_USER_NAME_FILTER);

				// Set up filter (SQL WHERE clause) and get return SQL
				// SQL constructor in users class, usersinfo.php

				$this->CurrentFilter = $sFilter;
				$sUserSql = $this->SQL();
				if ($rs = $conn->Execute($sUserSql)) {
					if (!$rs->EOF) {
						$bUserExists = TRUE;
						$this->RestoreFormValues(); // Restore form values
						$this->setFailureMessage($Language->Phrase("UserExists")); // Set user exist message
					}
					$rs->Close();
				}
				if (!$bUserExists) {
					$this->SendEmail = TRUE; // Send email on add success
					if ($this->AddRow()) { // Add record

						// Load user email
						$sReceiverEmail = $this->_Email->CurrentValue;
						if ($sReceiverEmail == "") { // Send to recipient directly
							$sReceiverEmail = EW_RECIPIENT_EMAIL;
							$sBccEmail = "";
						} else { // Bcc recipient
							$sBccEmail = EW_RECIPIENT_EMAIL;
						}

						// Set up email content
						if ($sReceiverEmail <> "") {
							$Email = new cEmail;

							// Begin of modification Email Template based on Selected Language, by Masino Sinaga, May 4, 2012
                            // Begin of modification Activate User Account by Admin, by Masino Sinaga, March 3, 2014

                            if (MS_SUSPEND_NEW_USER_ACCOUNT==TRUE) {

                              // Using the different email template if admin will activate user account
                              $Email->Load('phptxt/registerpending'.$GLOBALS["Language"]->LanguageId.'.txt');
                            } else {

                              // Begin of modification Email Template based on Selected Language, by Masino Sinaga, May 4, 2012
                              $Email->Load('phptxt/register'.$GLOBALS["Language"]->LanguageId.'.txt');

                              // End of modification Email Template based on Selected Language, by Masino Sinaga, May 4, 2012
                            }

                            // End of modification Activate User Account by Admin, by Masino Sinaga, March 3, 2014
                            // End of modification Email Template based on Selected Language, by Masino Sinaga, May 4, 2012
							// Begin of modification Displaying Application Name in Email Template, by Masino Sinaga, June 5, 2012

                            $Email->ReplaceSubject($Language->Phrase("SubjectRegistrationInformation").' '.$Language->ProjectPhrase("BodyTitle"));

                            // End of modification Displaying Application Name in Email Template, by Masino Sinaga, June 5, 2012
                            $Email->ReplaceSender(EW_SENDER_EMAIL); // Replace Sender
                            $Email->ReplaceRecipient($sReceiverEmail); // Replace Recipient
                            if ($sBccEmail <> "") $Email->AddBcc($sBccEmail); // Add Bcc
							$Email->ReplaceContent('<!--FieldCaption_Username-->', $this->Username->FldCaption());
							$Email->ReplaceContent('<!--Username-->', strval($this->Username->FormValue));
							$Email->ReplaceContent('<!--FieldCaption_Password-->', $this->Password->FldCaption());
							$Email->ReplaceContent('<!--Password-->', strval($this->Password->FormValue));
							$Email->ReplaceContent('<!--FieldCaption_First_Name-->', $this->First_Name->FldCaption());
							$Email->ReplaceContent('<!--First_Name-->', strval($this->First_Name->FormValue));
							$Email->ReplaceContent('<!--FieldCaption_Last_Name-->', $this->Last_Name->FldCaption());
							$Email->ReplaceContent('<!--Last_Name-->', strval($this->Last_Name->FormValue));
							$Email->ReplaceContent('<!--FieldCaption_Email-->', $this->_Email->FldCaption());
							$Email->ReplaceContent('<!--Email-->', strval($this->_Email->FormValue));

						// Begin of modification Activate User Account by Admin, by Masino Sinaga, March 3, 2014
                        if (MS_SUSPEND_NEW_USER_ACCOUNT==TRUE) {

                            // there is no activation link if admin will activate the user account
                        } else {
							$sActivateLink = ew_FullUrl() . "?action=confirm";
							$sActivateLink .= "&email=" . $this->_Email->CurrentValue;
							$sToken = ew_Encrypt($this->_Email->CurrentValue) . "," .
								ew_Encrypt($this->Username->CurrentValue) . "," .
								ew_Encrypt($this->Password->FormValue);
							$sActivateLink .= "&token=" . $sToken;
							$Email->ReplaceContent("<!--ActivateLink-->", $sActivateLink);
						}

                        // End of modification Activate User Account by Admin, by Masino Sinaga, March 3, 2014
							$Email->Charset = EW_EMAIL_CHARSET;

							// Get new recordset
							$this->CurrentFilter = $this->KeyFilter();
							$sSql = $this->SQL();
							$rsnew = $conn->Execute($sSql);
							$Args = array();
							$Args["rs"] = $rsnew->fields;
							$bEmailSent = FALSE;
							if ($this->Email_Sending($Email, $Args))
								$bEmailSent = $Email->Send();

							// Send email failed
							if (!$bEmailSent)
								$this->setFailureMessage($Email->SendErrDescription);
						}

						// Begin of modification by Masino Sinaga, for saving the registered date time, November 6, 2011
						$UserProfile->Profile[MS_USER_PROFILE_REGISTERED_DATE_TIME] = ew_StdCurrentDateTime();
						$UserProfile->SaveProfileToDatabase($sUsr);

						// End of modification by Masino Sinaga, for saving the registered date time, November 6, 2011		
						// Begin of modification Activate User Account by Admin, by Masino Sinaga, December 6, 2012

                        if ($this->getSuccessMessage() == "") {
                            if (MS_SUSPEND_NEW_USER_ACCOUNT==TRUE) {
                               $this->setSuccessMessage($Language->Phrase("RegisterSuccessPending")); // Activate success
                            } else {
                               $this->setSuccessMessage($Language->Phrase("RegisterSuccessActivate")); // Activate success
                            }
                        }

                        // End of modification Activate User Account by Admin, by Masino Sinaga, December 6, 2012
						$this->Page_Terminate("login.php"); // Return
					} else {
						$this->RestoreFormValues(); // Restore form values
					}
				}
		}

		// Render row
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render view
		} else {
			$this->RowType = EW_ROWTYPE_ADD; // Render add
		}
		$this->ResetAttrs();
		$this->RenderRow();
	}

	function CheckPasswordStrength() {
        global $Language, $gsFormError, $gsLanguage;

        // Check if validation required
        if (!EW_SERVER_VALIDATE)
            return TRUE;

        // Initialize form error message
        $gsFormError = "";
		if (MS_PASSWORD_POLICY_FROM_MASINO_REGISTER == TRUE) { 

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
        return $valid;
    }

	// Activate account based on email
	function ActivateEmail($email) {
		global $conn, $Language;
		$sFilter = str_replace("%e", ew_AdjustSql($email), EW_USER_EMAIL_FILTER);
		$sSql = $this->GetSQL($sFilter, "");
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if (!$rs)
			return FALSE;
		if (!$rs->EOF) {
			$rsnew = $rs->fields;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
			$rsact = array('Activated' => "Y"); // Auto register
			$this->CurrentFilter = $sFilter;
			$res = $this->Update($rsact);
			if ($res) { // Call User Activated event
				$rsnew['Activated'] = "Y";
				$this->User_Activated($rsnew);
			}
			return $res;
		} else {
			$this->setFailureMessage($Language->Phrase("NoRecord"));
			$rs->Close();
			return FALSE;
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Username->CurrentValue = NULL;
		$this->Username->OldValue = $this->Username->CurrentValue;
		$this->Password->CurrentValue = NULL;
		$this->Password->OldValue = $this->Password->CurrentValue;
		$this->First_Name->CurrentValue = NULL;
		$this->First_Name->OldValue = $this->First_Name->CurrentValue;
		$this->Last_Name->CurrentValue = NULL;
		$this->Last_Name->OldValue = $this->Last_Name->CurrentValue;
		$this->_Email->CurrentValue = NULL;
		$this->_Email->OldValue = $this->_Email->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Username->FldIsDetailKey) {
			$this->Username->setFormValue($objForm->GetValue("x_Username"));
		}
		if (!$this->Password->FldIsDetailKey) {
			$this->Password->setFormValue($objForm->GetValue("x_Password"));
		}
		$this->Password->ConfirmValue = $objForm->GetValue("c_Password");
		if (!$this->First_Name->FldIsDetailKey) {
			$this->First_Name->setFormValue($objForm->GetValue("x_First_Name"));
		}
		if (!$this->Last_Name->FldIsDetailKey) {
			$this->Last_Name->setFormValue($objForm->GetValue("x_Last_Name"));
		}
		if (!$this->_Email->FldIsDetailKey) {
			$this->_Email->setFormValue($objForm->GetValue("x__Email"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Username->CurrentValue = $this->Username->FormValue;
		$this->Password->CurrentValue = $this->Password->FormValue;
		$this->First_Name->CurrentValue = $this->First_Name->FormValue;
		$this->Last_Name->CurrentValue = $this->Last_Name->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
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
		$this->Username->setDbValue($rs->fields('Username'));
		$this->Password->setDbValue($rs->fields('Password'));
		$this->First_Name->setDbValue($rs->fields('First_Name'));
		$this->Last_Name->setDbValue($rs->fields('Last_Name'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->User_Level->setDbValue($rs->fields('User_Level'));
		$this->Report_To->setDbValue($rs->fields('Report_To'));
		$this->Activated->setDbValue($rs->fields('Activated'));
		$this->Locked->setDbValue($rs->fields('Locked'));
		$this->Profile->setDbValue($rs->fields('Profile'));
		$this->Current_URL->setDbValue($rs->fields('Current_URL'));
		$this->Theme->setDbValue($rs->fields('Theme'));
		$this->Menu_Horizontal->setDbValue($rs->fields('Menu_Horizontal'));
		$this->Table_Width_Style->setDbValue($rs->fields('Table_Width_Style'));
		$this->Scroll_Table_Width->setDbValue($rs->fields('Scroll_Table_Width'));
		$this->Scroll_Table_Height->setDbValue($rs->fields('Scroll_Table_Height'));
		$this->Rows_Vertical_Align_Top->setDbValue($rs->fields('Rows_Vertical_Align_Top'));
		$this->_Language->setDbValue($rs->fields('Language'));
		$this->Redirect_To_Last_Visited_Page_After_Login->setDbValue($rs->fields('Redirect_To_Last_Visited_Page_After_Login'));
		$this->Font_Name->setDbValue($rs->fields('Font_Name'));
		$this->Font_Size->setDbValue($rs->fields('Font_Size'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Username->DbValue = $row['Username'];
		$this->Password->DbValue = $row['Password'];
		$this->First_Name->DbValue = $row['First_Name'];
		$this->Last_Name->DbValue = $row['Last_Name'];
		$this->_Email->DbValue = $row['Email'];
		$this->User_Level->DbValue = $row['User_Level'];
		$this->Report_To->DbValue = $row['Report_To'];
		$this->Activated->DbValue = $row['Activated'];
		$this->Locked->DbValue = $row['Locked'];
		$this->Profile->DbValue = $row['Profile'];
		$this->Current_URL->DbValue = $row['Current_URL'];
		$this->Theme->DbValue = $row['Theme'];
		$this->Menu_Horizontal->DbValue = $row['Menu_Horizontal'];
		$this->Table_Width_Style->DbValue = $row['Table_Width_Style'];
		$this->Scroll_Table_Width->DbValue = $row['Scroll_Table_Width'];
		$this->Scroll_Table_Height->DbValue = $row['Scroll_Table_Height'];
		$this->Rows_Vertical_Align_Top->DbValue = $row['Rows_Vertical_Align_Top'];
		$this->_Language->DbValue = $row['Language'];
		$this->Redirect_To_Last_Visited_Page_After_Login->DbValue = $row['Redirect_To_Last_Visited_Page_After_Login'];
		$this->Font_Name->DbValue = $row['Font_Name'];
		$this->Font_Size->DbValue = $row['Font_Size'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Username
		// Password
		// First_Name
		// Last_Name
		// Email
		// User_Level
		// Report_To
		// Activated
		// Locked
		// Profile
		// Current_URL
		// Theme
		// Menu_Horizontal
		// Table_Width_Style
		// Scroll_Table_Width
		// Scroll_Table_Height
		// Rows_Vertical_Align_Top
		// Language
		// Redirect_To_Last_Visited_Page_After_Login
		// Font_Name
		// Font_Size

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Username
		$this->Username->ViewValue = $this->Username->CurrentValue;
		$this->Username->ViewCustomAttributes = "";

		// Password
		$this->Password->ViewValue = $Language->Phrase("PasswordMask");
		$this->Password->ViewCustomAttributes = "";

		// First_Name
		$this->First_Name->ViewValue = $this->First_Name->CurrentValue;
		$this->First_Name->ViewCustomAttributes = "";

		// Last_Name
		$this->Last_Name->ViewValue = $this->Last_Name->CurrentValue;
		$this->Last_Name->ViewCustomAttributes = "";

		// Email
		$this->_Email->ViewValue = $this->_Email->CurrentValue;
		$this->_Email->ViewCustomAttributes = "";

		// Activated
		if (ew_ConvertToBool($this->Activated->CurrentValue)) {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(2) <> "" ? $this->Activated->FldTagCaption(2) : "Yes";
		} else {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(1) <> "" ? $this->Activated->FldTagCaption(1) : "No";
		}
		$this->Activated->ViewCustomAttributes = "";

		// Locked
		if (ew_ConvertToBool($this->Locked->CurrentValue)) {
			$this->Locked->ViewValue = $this->Locked->FldTagCaption(1) <> "" ? $this->Locked->FldTagCaption(1) : "Yes";
		} else {
			$this->Locked->ViewValue = $this->Locked->FldTagCaption(2) <> "" ? $this->Locked->FldTagCaption(2) : "No";
		}
		$this->Locked->ViewCustomAttributes = "";

			// Username
			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";
			$this->Username->TooltipValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";
			$this->Password->TooltipValue = "";

			// First_Name
			$this->First_Name->LinkCustomAttributes = "";
			$this->First_Name->HrefValue = "";
			$this->First_Name->TooltipValue = "";

			// Last_Name
			$this->Last_Name->LinkCustomAttributes = "";
			$this->Last_Name->HrefValue = "";
			$this->Last_Name->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Username
			$this->Username->EditAttrs["class"] = "form-control";
			$this->Username->EditCustomAttributes = "";
			$this->Username->EditValue = ew_HtmlEncode($this->Username->CurrentValue);
			$this->Username->PlaceHolder = ew_RemoveHtml($this->Username->FldCaption());

			// Password
			$this->Password->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->CurrentValue);
			$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

			// First_Name
			$this->First_Name->EditAttrs["class"] = "form-control";
			$this->First_Name->EditCustomAttributes = "";
			$this->First_Name->EditValue = ew_HtmlEncode($this->First_Name->CurrentValue);
			$this->First_Name->PlaceHolder = ew_RemoveHtml($this->First_Name->FldCaption());

			// Last_Name
			$this->Last_Name->EditAttrs["class"] = "form-control";
			$this->Last_Name->EditCustomAttributes = "";
			$this->Last_Name->EditValue = ew_HtmlEncode($this->Last_Name->CurrentValue);
			$this->Last_Name->PlaceHolder = ew_RemoveHtml($this->Last_Name->FldCaption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

			// Add refer script
			// Username

			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";

			// First_Name
			$this->First_Name->LinkCustomAttributes = "";
			$this->First_Name->HrefValue = "";

			// Last_Name
			$this->Last_Name->LinkCustomAttributes = "";
			$this->Last_Name->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->Username->FldIsDetailKey && !is_null($this->Username->FormValue) && $this->Username->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterUserName"));
		}
		if (!$this->Password->FldIsDetailKey && !is_null($this->Password->FormValue) && $this->Password->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterPassword"));
		}
		if ($this->Password->ConfirmValue <> $this->Password->FormValue) {
			ew_AddMessage($gsFormError, $Language->Phrase("MismatchPassword"));
		}
		if (!$this->_Email->FldIsDetailKey && !is_null($this->_Email->FormValue) && $this->_Email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_Email->FldCaption(), $this->_Email->ReqErrMsg));
		}
		if (!ew_CheckEmail($this->_Email->FormValue)) {
			ew_AddMessage($gsFormError, $this->_Email->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Username
		$this->Username->SetDbValueDef($rsnew, $this->Username->CurrentValue, "", FALSE);

		// Password
		$this->Password->SetDbValueDef($rsnew, $this->Password->CurrentValue, "", FALSE);

		// First_Name
		$this->First_Name->SetDbValueDef($rsnew, $this->First_Name->CurrentValue, NULL, FALSE);

		// Last_Name
		$this->Last_Name->SetDbValueDef($rsnew, $this->Last_Name->CurrentValue, NULL, FALSE);

		// Email
		$this->_Email->SetDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Username']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);

			// Call User Registered event
			$this->User_Registered($rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
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

	// User Registered event
	function User_Registered(&$rs) {

	  //echo "User_Registered";
	}

	// User Activated event
	function User_Activated(&$rs) {

	  //echo "User_Activated";
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($register)) $register = new cregister();

// Page init
$register->Page_Init();

// Page main
$register->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$register->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "register";
var CurrentForm = fregister = new ew_Form("fregister", "register");

// Validate form
fregister.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterUserName"));
			elm = this.GetElements("x" + infix + "_Password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterPassword"));
			if ($(fobj.x_Password).hasClass("ewPasswordStrength") && !$(fobj.x_Password).data("validated"))
				return this.OnError(fobj.x_Password, ewLanguage.Phrase("PasswordTooSimple"));
			if (fobj.c_Password.value != fobj.x_Password.value)
				return this.OnError(fobj.c_Password, ewLanguage.Phrase("MismatchPassword"));
			elm = this.GetElements("x" + infix + "__Email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->_Email->FldCaption(), $users->_Email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__Email");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->_Email->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
		if (fobj.captcha && !ew_HasValue(fobj.captcha))
			return this.OnError(fobj.captcha, ewLanguage.Phrase("EnterValidateCode"));
	return true;
}

// Form_CustomValidate event
fregister.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fregister.ValidateRequired = true;
<?php } else { ?>
fregister.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (MS_SHOW_BREADCRUMBLINKS_ON_REGISTER_PAGE) { ?>
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
<?php $register->ShowPageHeader(); ?>
<?php
$register->ShowMessage();
?>
<form name="fregister" id="fregister" class="form-horizontal ewForm ewRegisterForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if (MS_REGISTER_WINDOW_TYPE=="default" || MS_REGISTER_WINDOW_TYPE=="") { ?>
<div class="col-sm-8 col-sm-offset-2">
<div class="panel <?php echo MS_REGISTER_FORM_PANEL_TYPE; ?>">
<div class="panel-heading"><strong><?php echo $Language->Phrase("RegisterPage") ?></strong><?php if (@MS_SHOW_HELP_ONLINE) { ?> &nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a> <?php } ?></div>
<div class="panel-body">
<br>
<?php } else { ?>
<div id="msRegisterDialog" class="modal fade">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">x</span></button><h4 class="modal-title"><?php echo $Language->Phrase("RegisterPage") ?><?php if (@MS_SHOW_HELP_ONLINE) { ?> &nbsp;<a href='javascript:void(0);' id='helponline' onclick='msHelpDialogShow()'><span class='glyphicon glyphicon-question-sign ewIconHelp'></span></a> <?php } ?></h4></div>
<div class="modal-body">
<br>
<?php } ?>
<?php if ($register->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $register->Token ?>">
<?php } ?>
<?php // Begin of modification Terms and Conditions, by Masino Sinaga, July 14, 2014 ?>
<?php if ( ($users->CurrentAction == "F") ||
          ($users->CurrentAction == "I") ||
           ($users->CurrentAction == "A") ||
           ($users->CurrentAction == "X") ||
           (MS_SHOW_TERMS_AND_CONDITIONS_ON_REGISTRATION_PAGE == FALSE) ) { ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_register" id="a_register" value="A">
<?php if ($users->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } elseif ($users->CurrentAction == "T") { ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="T">
<?php } ?>
<?php // End of modification Terms and Conditions, by Masino Sinaga, July 14, 2014 ?>
<div>
<?php if ($users->Username->Visible) { // Username ?>
	<div id="r_Username" class="form-group">
		<label id="elh_users_Username" for="x_Username" class="col-sm-4 control-label ewLabel"><?php echo $users->Username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $users->Username->CellAttributes() ?>>
<?php if ($users->CurrentAction <> "F") { ?>
<span id="el_users_Username">
<input type="text" data-table="users" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->Username->getPlaceHolder()) ?>" value="<?php echo $users->Username->EditValue ?>"<?php echo $users->Username->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_users_Username">
<span<?php echo $users->Username->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->Username->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="x_Username" name="x_Username" id="x_Username" value="<?php echo ew_HtmlEncode($users->Username->FormValue) ?>">
<?php } ?>
<?php echo $users->Username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Password->Visible) { // Password ?>
	<?php if (MS_PASSWORD_POLICY_FROM_MASINO_REGISTER == TRUE) { ?>
	<?php if ($users->CurrentAction <> "F") { ?>
		<div id="r_Password" class="form-group">
			<label id="elh_users_Password" for="x_Password" class="col-sm-4 control-label ewLabel"><?php echo $users->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
			<div class="col-sm-8">
				<div <?php echo $users->Password->CellAttributes() ?>>
					<span id="el_users_Password">
					<input type="password" name="x_Password" id="x_Password" size="30" maxlength="50" value="<?php echo ew_HtmlEncode($users->Password->FormValue) ?>" placeholder="<?php echo $users->Password->FldCaption() ?>" onkeyup="passwordStrength(this.value, c_Password.value)" <?php echo $users->Password->EditAttributes() ?>>
					</span>
					<div id="passwordDescription"><?php echo $Language->Phrase("empty"); ?></div>
					<div class="password-meter-bg">
						<div id="passwordStrength" class="strength0"></div>
					</div>              
			   <?php echo $users->Password->CustomMsg ?>
				</div>
			</div>
		</div>
	<?php } else { // hidden ?>
		<div id="r_Password" class="form-group">
			<label id="elh_users_Password" for="x_Password" class="col-sm-4 control-label ewLabel"><?php echo $users->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
			<div class="col-sm-8"> 
				*****************<?php echo $users->Password->ViewValue ?><input type="hidden" name="x_Password" id="x_Password" value="<?php echo ew_HtmlEncode($users->Password->FormValue) ?>">
			   <?php echo $users->Password->CustomMsg ?>
			</div>
		</div>
	<?php } ?>
	<?php } else { // Begin of Password from PHPMaker built-in ?>
		<?php if ($users->Password->Visible) { // Password ?>
		<div id="r_Password" class="form-group">
			<label id="elh_users_Password" for="x_Password" class="col-sm-4 control-label ewLabel"><?php echo $users->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
			<div class="col-sm-8"><div<?php echo $users->Password->CellAttributes() ?>>
<?php if ($users->CurrentAction <> "F") { ?>
<span id="el_users_Password">
<div class="input-group" id="ig_x_Password">
<input type="password" data-password-strength="pst_x_Password" data-password-generated="pgt_x_Password" data-table="users" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($users->Password->getPlaceHolder()) ?>"<?php echo $users->Password->EditAttributes() ?>>
<span class="input-group-btn">
	<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="x_Password" data-password-confirm="c_Password" data-password-strength="pst_x_Password" data-password-generated="pgt_x_Password"><?php echo $Language->Phrase("GeneratePassword") ?></button>
</span>
</div>
<span class="help-block" id="pgt_x_Password" style="display: none;"></span>
<div class="progress ewPasswordStrengthBar" id="pst_x_Password" style="display: none;">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php } else { ?>
<span id="el_users_Password">
<span<?php echo $users->Password->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->Password->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="x_Password" name="x_Password" id="x_Password" value="<?php echo ew_HtmlEncode($users->Password->FormValue) ?>">
<?php } ?>
<?php echo $users->Password->CustomMsg ?></div></div>
		</div>
		<?php } ?>
	<?php } // End of Password from PHPMaker built-in ?>
<?php } ?>
<?php if ($users->Password->Visible) { // Password ?>
	<?php if (MS_PASSWORD_POLICY_FROM_MASINO_REGISTER == TRUE) { ?>
	<?php if ($users->CurrentAction <> "F") { ?>
		<div id="r_c_Password" class="form-group">
			<label id="elh_c_users_Password" for="c_Password" class="col-sm-4 control-label ewLabel"><?php echo $Language->Phrase("Confirm") ?> <?php echo $users->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
			<div class="col-sm-8">
				<div <?php echo $users->Password->CellAttributes() ?>>
					<span id="el_users_c_Password">
					<input type="password" name="c_Password" id="c_Password" size="30" maxlength="50" value="<?php echo ew_HtmlEncode($users->Password->FormValue) ?>" placeholder="<?php echo $Language->Phrase("Confirm") ?>&nbsp;<?php echo $users->Password->FldCaption() ?>" onkeyup="passwordConfirmation(x_Password.value, this.value)" <?php echo $users->Password->EditAttributes() ?>>
					</span>
						<div id="passconfDescription"><?php echo $Language->Phrase("match"); ?></div>
						<div class="password-meter-bg">        
							<div id="passconfConfirmation" class="conf1"></div>
						</div>          
			  <?php echo $users->Password->CustomMsg ?>
				</div>
			</div>
		</div>
	<?php } else { // hidden ?>
		<div id="r_c_Password" class="form-group">
			<label id="elh_c_users_Password" for="c_Password" class="col-sm-4 control-label ewLabel"><?php echo $Language->Phrase("Confirm") ?> <?php echo $users->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
			<div class="col-sm-8"> 
				*****************<?php echo $users->Password->ViewValue ?><input type="hidden" name="c_Password" id="c_Password" value="<?php echo ew_HtmlEncode($users->Password->FormValue) ?>">
			   <?php echo $users->Password->CustomMsg ?>
			</div>
		</div>
	<?php } ?>
	<?php } else { // Begin of Password Policy from PHPMaker built-in ?>
	<div id="r_c_Password" class="form-group">
		<label id="elh_c_users_Password" for="c_Password" class="col-sm-4 control-label ewLabel"><?php echo $Language->Phrase("Confirm") ?> <?php echo $users->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $users->Password->CellAttributes() ?>>
<?php if ($users->CurrentAction <> "F") { ?>
<span id="el_c_users_Password">
<input type="password" data-field="c_Password" name="c_Password" id="c_Password" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($users->Password->getPlaceHolder()) ?>"<?php echo $users->Password->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_c_users_Password">
<span<?php echo $users->Password->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->Password->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="c_Password" name="c_Password" id="c_Password" value="<?php echo ew_HtmlEncode($users->Password->FormValue) ?>">
<?php } ?>
</div></div>
	</div>
	<?php } // End of Password Policy from PHPMaker built-in  ?>
<?php } ?>
<?php if ($users->First_Name->Visible) { // First_Name ?>
	<div id="r_First_Name" class="form-group">
		<label id="elh_users_First_Name" for="x_First_Name" class="col-sm-4 control-label ewLabel"><?php echo $users->First_Name->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->First_Name->CellAttributes() ?>>
<?php if ($users->CurrentAction <> "F") { ?>
<span id="el_users_First_Name">
<input type="text" data-table="users" data-field="x_First_Name" name="x_First_Name" id="x_First_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->First_Name->getPlaceHolder()) ?>" value="<?php echo $users->First_Name->EditValue ?>"<?php echo $users->First_Name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_users_First_Name">
<span<?php echo $users->First_Name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->First_Name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="x_First_Name" name="x_First_Name" id="x_First_Name" value="<?php echo ew_HtmlEncode($users->First_Name->FormValue) ?>">
<?php } ?>
<?php echo $users->First_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Last_Name->Visible) { // Last_Name ?>
	<div id="r_Last_Name" class="form-group">
		<label id="elh_users_Last_Name" for="x_Last_Name" class="col-sm-4 control-label ewLabel"><?php echo $users->Last_Name->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Last_Name->CellAttributes() ?>>
<?php if ($users->CurrentAction <> "F") { ?>
<span id="el_users_Last_Name">
<input type="text" data-table="users" data-field="x_Last_Name" name="x_Last_Name" id="x_Last_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->Last_Name->getPlaceHolder()) ?>" value="<?php echo $users->Last_Name->EditValue ?>"<?php echo $users->Last_Name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_users_Last_Name">
<span<?php echo $users->Last_Name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->Last_Name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="x_Last_Name" name="x_Last_Name" id="x_Last_Name" value="<?php echo ew_HtmlEncode($users->Last_Name->FormValue) ?>">
<?php } ?>
<?php echo $users->Last_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group">
		<label id="elh_users__Email" for="x__Email" class="col-sm-4 control-label ewLabel"><?php echo $users->_Email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $users->_Email->CellAttributes() ?>>
<?php if ($users->CurrentAction <> "F") { ?>
<span id="el_users__Email">
<input type="text" data-table="users" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($users->_Email->getPlaceHolder()) ?>" value="<?php echo $users->_Email->EditValue ?>"<?php echo $users->_Email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_users__Email">
<span<?php echo $users->_Email->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->_Email->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="x__Email" name="x__Email" id="x__Email" value="<?php echo ew_HtmlEncode($users->_Email->FormValue) ?>">
<?php } ?>
<?php echo $users->_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (MS_SHOW_CAPTCHA_ON_REGISTRATION_PAGE == TRUE) { ?>
<?php if ($users->CurrentAction <> "F") { ?>
<!-- captcha html (begin) -->
<div class="form-group">
	<div class=" col-sm-offset-4 col-sm-8 ">
	<img src="ewcaptcha.php" alt="Security Image" style="width: 200px; height: 50px;"><br><br>
	<input type="text" name="captcha" id="captcha" class="form-control" size="30" placeholder="<?php echo $Language->Phrase("EnterValidateCode") ?>">
	</div>
</div>
<?php } else { ?>
<input type="hidden" name="captcha" id="captcha" value="<?php echo $register->captcha ?>">
<?php } ?>
<!-- captcha html (end) -->
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<?php if ($users->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_register.value='F';"><?php echo $Language->Phrase("RegisterBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_register.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div>
</div>
<?php } else { // Terms and Conditions page ?>
<?php
if (@MS_USE_CONSTANTS_IN_CONFIG_FILE == FALSE) {
  $sSql = "SELECT Terms_And_Condition_Text FROM ".MS_LANGUAGES_TABLE."
         WHERE Language_Code = '".$gsLanguage."'";              
  $rs = ew_Execute($sSql);
  $tactitle = $Language->Phrase("TaCTitle");
  if ($rs && $rs->RecordCount() > 0) {
    $taccontent = $rs->fields("Terms_And_Condition_Text");
	$taccontent = str_replace("<br>", "\n", $taccontent);
	$taccontent = str_replace("<br>", "\n", $taccontent);
	$taccontent = str_replace("<strong>", "", $taccontent);
	$taccontent = str_replace("</strong>", "", $taccontent);
  } else {
    $taccontent = $Language->Phrase("TaCContent");
  }
} else {
  $tactitle = $Language->Phrase("TaCTitle");
  $taccontent = $Language->Phrase("TACNotAvailable");
}
?>
<div class="form-group" id="r_TAC">
	<div class="col-sm-10">
		<textarea class="form-control ewControl" id="tactextarea" cols="50" rows="10" readonly style="max-width:430px; min-width:200px; max-height:300px; min-height:200px;"><?php echo $taccontent ?></textarea>
	</div>
</div>
<?php if (MS_TERMS_AND_CONDITION_CHECKBOX_ON_REGISTER_PAGE == TRUE) { ?>
<div class="form-group">
	<div class="col-sm-10">
		<label class="checkbox-inline ewCheckBox" style="white-space: nowrap;">
		<?php $selwrk = (@isset($_POST["chktac"])) ? " checked='checked'" : ""; ?>
		<input type="checkbox" name="chktac" id="chktac" value="<?php echo @$_POST["chktac"]; ?>" <?php echo $selwrk; ?>>&nbsp;<?php echo $Language->Phrase("IAgreeWith"); ?>&nbsp;<?php echo $Language->Phrase("TaCTitle"); ?>&nbsp;<a href="printtac.php"><?php echo Language()->Phrase("Print"); ?></a>
		</label>
	</div>
</div>
<?php } ?>
<div class="form-group" id="r_RegisterButton">
	<div class="col-sm-10">
		<input type="hidden" name="a_register" id="a_register" value="I">
		<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"  onclick="this.form.a_register.value='I';"><?php echo $Language->Phrase("IAgree"); ?></button>
	</div>
</div>
<?php } // Terms and Conditions page ?>
</div>
<?php if (MS_REGISTER_WINDOW_TYPE=="default" || MS_REGISTER_WINDOW_TYPE=="") { ?>
<div class="panel-footer <?php echo MS_REGISTER_FORM_PANEL_TYPE; ?>">
	<div>
		<a class="ewLink ewLinkSeparator" href="login.php"><?php echo $Language->Phrase("Login") ?></a>
		<a class="ewLink ewLinkSeparator" href="forgotpwd.php"><?php echo $Language->Phrase("ForgotPwd") ?></a>
	</div>
</div>
</div>
</div>
<?php } else { ?>
<div class="modal-footer">
	<div class="pull-left">
		<a class="ewLink ewLinkSeparator" href="login.php"><?php echo $Language->Phrase("Login") ?></a>
		<a class="ewLink ewLinkSeparator" href="forgotpwd.php"><?php echo $Language->Phrase("ForgotPwd") ?></a>
	</div>
</div>
</div>
</div>
</div>
<?php } ?>
</form>
<script type="text/javascript" src="phpjs/register_dialog.js"></script>
<script type="text/javascript">
fregister.Init();
$(document).ready(function(){
<?php if (MS_REGISTER_WINDOW_TYPE=="popup") { ?>
msRegisterDialogShow();
<?php } ?>
<?php if (MS_TERMS_AND_CONDITION_CHECKBOX_ON_REGISTER_PAGE == TRUE) { ?>
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
$register->ShowPageFooter();
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
$(document).ready(function(){$("#fregister:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
$('#fregister:first *:input[type!=hidden]:first').focus();
});
$(document).ready(function(){
var password = document.getElementById("x_Password").value;
var password2 = document.getElementById("c_Password").value;
passwordStrength(password, password2);
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
$register->Page_Terminate();
?>
