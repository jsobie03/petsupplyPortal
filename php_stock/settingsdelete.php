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

$settings_delete = NULL; // Initialize page object first

class csettings_delete extends csettings {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'settings';

	// Page object name
	var $PageObjName = 'settings_delete';

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

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("settingslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in settings class, settingsinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Option_ID'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("settingslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url); // v11.0.4
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($settings_delete)) $settings_delete = new csettings_delete();

// Page init
$settings_delete->Page_Init();

// Page main
$settings_delete->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$settings_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fsettingsdelete = new ew_Form("fsettingsdelete", "delete");

// Form_CustomValidate event
fsettingsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsettingsdelete.ValidateRequired = true;
<?php } else { ?>
fsettingsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsettingsdelete.Lists["x_Option_Default[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsdelete.Lists["x_Option_Default[]"].Options = <?php echo json_encode($settings->Option_Default->Options()) ?>;
fsettingsdelete.Lists["x_Default_Theme"] = {"LinkField":"x_Theme_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Theme_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsdelete.Lists["x_Show_Border_Layout[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsdelete.Lists["x_Show_Border_Layout[]"].Options = <?php echo json_encode($settings->Show_Border_Layout->Options()) ?>;
fsettingsdelete.Lists["x_Show_Shadow_Layout[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsdelete.Lists["x_Show_Shadow_Layout[]"].Options = <?php echo json_encode($settings->Show_Shadow_Layout->Options()) ?>;
fsettingsdelete.Lists["x_Menu_Horizontal[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsdelete.Lists["x_Menu_Horizontal[]"].Options = <?php echo json_encode($settings->Menu_Horizontal->Options()) ?>;
fsettingsdelete.Lists["x_Show_Announcement"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsdelete.Lists["x_Show_Announcement"].Options = <?php echo json_encode($settings->Show_Announcement->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($settings_delete->Recordset = $settings_delete->LoadRecordset())
	$settings_deleteTotalRecs = $settings_delete->Recordset->RecordCount(); // Get record count
if ($settings_deleteTotalRecs <= 0) { // No record found, exit
	if ($settings_delete->Recordset)
		$settings_delete->Recordset->Close();
	$settings_delete->Page_Terminate("settingslist.php"); // Return to list
}
?>
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
<?php $settings_delete->ShowPageHeader(); ?>
<?php
$settings_delete->ShowMessage();
?>
<form name="fsettingsdelete" id="fsettingsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($settings_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $settings_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="settings">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($settings_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $settings->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($settings->Option_ID->Visible) { // Option_ID ?>
		<th><span id="elh_settings_Option_ID" class="settings_Option_ID"><?php echo $settings->Option_ID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->Option_Default->Visible) { // Option_Default ?>
		<th><span id="elh_settings_Option_Default" class="settings_Option_Default"><?php echo $settings->Option_Default->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->Default_Theme->Visible) { // Default_Theme ?>
		<th><span id="elh_settings_Default_Theme" class="settings_Default_Theme"><?php echo $settings->Default_Theme->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->Show_Border_Layout->Visible) { // Show_Border_Layout ?>
		<th><span id="elh_settings_Show_Border_Layout" class="settings_Show_Border_Layout"><?php echo $settings->Show_Border_Layout->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->Show_Shadow_Layout->Visible) { // Show_Shadow_Layout ?>
		<th><span id="elh_settings_Show_Shadow_Layout" class="settings_Show_Shadow_Layout"><?php echo $settings->Show_Shadow_Layout->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->Menu_Horizontal->Visible) { // Menu_Horizontal ?>
		<th><span id="elh_settings_Menu_Horizontal" class="settings_Menu_Horizontal"><?php echo $settings->Menu_Horizontal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->Show_Announcement->Visible) { // Show_Announcement ?>
		<th><span id="elh_settings_Show_Announcement" class="settings_Show_Announcement"><?php echo $settings->Show_Announcement->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$settings_delete->RecCnt = 0;
$i = 0;
while (!$settings_delete->Recordset->EOF) {
	$settings_delete->RecCnt++;
	$settings_delete->RowCnt++;

	// Set row properties
	$settings->ResetAttrs();
	$settings->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$settings_delete->LoadRowValues($settings_delete->Recordset);

	// Render row
	$settings_delete->RenderRow();
?>
	<tr<?php echo $settings->RowAttributes() ?>>
<?php if ($settings->Option_ID->Visible) { // Option_ID ?>
		<td<?php echo $settings->Option_ID->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_Option_ID" class="settings_Option_ID">
<span<?php echo $settings->Option_ID->ViewAttributes() ?>>
<?php echo $settings->Option_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->Option_Default->Visible) { // Option_Default ?>
		<td<?php echo $settings->Option_Default->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_Option_Default" class="settings_Option_Default">
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
		<td<?php echo $settings->Default_Theme->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_Default_Theme" class="settings_Default_Theme">
<span<?php echo $settings->Default_Theme->ViewAttributes() ?>>
<?php echo $settings->Default_Theme->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->Show_Border_Layout->Visible) { // Show_Border_Layout ?>
		<td<?php echo $settings->Show_Border_Layout->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_Show_Border_Layout" class="settings_Show_Border_Layout">
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
		<td<?php echo $settings->Show_Shadow_Layout->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_Show_Shadow_Layout" class="settings_Show_Shadow_Layout">
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
		<td<?php echo $settings->Menu_Horizontal->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_Menu_Horizontal" class="settings_Menu_Horizontal">
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
		<td<?php echo $settings->Show_Announcement->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_Show_Announcement" class="settings_Show_Announcement">
<span<?php echo $settings->Show_Announcement->ViewAttributes() ?>>
<?php echo $settings->Show_Announcement->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$settings_delete->Recordset->MoveNext();
}
$settings_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $settings_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fsettingsdelete.Init();
</script>
<?php
$settings_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyDelete(this)'); function alertifyDelete(obj) { <?php global $Language; ?> if (fsettingsdelete.Validate() == true ) { alertify.confirm("<?php echo  $Language->Phrase('AlertifyDeleteConfirm'); ?>", function (e) { if (e) {	$(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyDelete'); ?>"); $("#fsettingsdelete").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$settings_delete->Page_Terminate();
?>
