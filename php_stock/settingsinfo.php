<?php

// Global variable for table object
$settings = NULL;

//
// Table class for settings
//
class csettings extends cTable {
	var $Option_ID;
	var $Option_Default;
	var $Default_Theme;
	var $Font_Name;
	var $Font_Size;
	var $Show_Border_Layout;
	var $Show_Shadow_Layout;
	var $Menu_Horizontal;
	var $Vertical_Menu_Width;
	var $Show_Announcement;
	var $Demo_Mode;
	var $Show_Page_Processing_Time;
	var $Allow_User_Preferences;
	var $SMTP_Server;
	var $SMTP_Server_Port;
	var $SMTP_Server_Username;
	var $SMTP_Server_Password;
	var $Sender_Email;
	var $Recipient_Email;
	var $Use_Default_Locale;
	var $Default_Language;
	var $Default_Timezone;
	var $Default_Thousands_Separator;
	var $Default_Decimal_Point;
	var $Default_Currency_Symbol;
	var $Default_Money_Thousands_Separator;
	var $Default_Money_Decimal_Point;
	var $Maintenance_Mode;
	var $Maintenance_Finish_DateTime;
	var $Auto_Normal_After_Maintenance;
	var $Allow_User_To_Register;
	var $Suspend_New_User_Account;
	var $User_Need_Activation_After_Registered;
	var $Show_Captcha_On_Registration_Page;
	var $Show_Terms_And_Conditions_On_Registration_Page;
	var $User_Auto_Login_After_Activation_Or_Registration;
	var $Show_Captcha_On_Login_Page;
	var $Show_Captcha_On_Forgot_Password_Page;
	var $Show_Captcha_On_Change_Password_Page;
	var $User_Auto_Logout_After_Idle_In_Minutes;
	var $User_Login_Maximum_Retry;
	var $User_Login_Retry_Lockout;
	var $Redirect_To_Last_Visited_Page_After_Login;
	var $Enable_Password_Expiry;
	var $Password_Expiry_In_Days;
	var $Show_Entire_Header;
	var $Logo_Width;
	var $Show_Site_Title_In_Header;
	var $Show_Current_User_In_Header;
	var $Text_Align_In_Header;
	var $Site_Title_Text_Style;
	var $Language_Selector_Visibility;
	var $Language_Selector_Align;
	var $Show_Entire_Footer;
	var $Show_Text_In_Footer;
	var $Show_Back_To_Top_On_Footer;
	var $Show_Terms_And_Conditions_On_Footer;
	var $Show_About_Us_On_Footer;
	var $Pagination_Position;
	var $Pagination_Style;
	var $Selectable_Records_Per_Page;
	var $Selectable_Groups_Per_Page;
	var $Default_Record_Per_Page;
	var $Default_Group_Per_Page;
	var $Maximum_Selected_Records;
	var $Maximum_Selected_Groups;
	var $Show_PageNum_If_Record_Not_Over_Pagesize;
	var $Table_Width_Style;
	var $Scroll_Table_Width;
	var $Scroll_Table_Height;
	var $Search_Panel_Collapsed;
	var $Filter_Panel_Collapsed;
	var $Show_Record_Number_On_List_Page;
	var $Show_Empty_Table_On_List_Page;
	var $Rows_Vertical_Align_Top;
	var $Action_Button_Alignment;
	var $Show_Add_Success_Message;
	var $Show_Edit_Success_Message;
	var $jQuery_Auto_Hide_Success_Message;
	var $Use_Javascript_Message;
	var $Login_Window_Type;
	var $Forgot_Password_Window_Type;
	var $Change_Password_Window_Type;
	var $Registration_Window_Type;
	var $Show_Record_Number_On_Detail_Preview;
	var $Show_Empty_Table_In_Detail_Preview;
	var $Detail_Preview_Table_Width;
	var $Password_Minimum_Length;
	var $Password_Maximum_Length;
	var $Password_Must_Contain_At_Least_One_Lower_Case;
	var $Password_Must_Comply_With_Minumum_Length;
	var $Password_Must_Comply_With_Maximum_Length;
	var $Password_Must_Contain_At_Least_One_Upper_Case;
	var $Password_Must_Contain_At_Least_One_Numeric;
	var $Password_Must_Contain_At_Least_One_Symbol;
	var $Password_Must_Be_Difference_Between_Old_And_New;
	var $Reset_Password_Field_Options;
	var $Export_Record_Options;
	var $Show_Record_Number_On_Exported_List_Page;
	var $Use_Table_Setting_For_Export_Field_Caption;
	var $Use_Table_Setting_For_Export_Original_Value;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'settings';
		$this->TableName = 'settings';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`settings`";
		$this->DBID = 'DB';

		// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
        $this->ExportAll = MS_EXPORT_RECORD_OPTIONS;

// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Option_ID
		$this->Option_ID = new cField('settings', 'settings', 'x_Option_ID', 'Option_ID', '`Option_ID`', '`Option_ID`', 19, -1, FALSE, '`Option_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Option_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Option_ID'] = &$this->Option_ID;

		// Option_Default
		$this->Option_Default = new cField('settings', 'settings', 'x_Option_Default', 'Option_Default', '`Option_Default`', '`Option_Default`', 202, -1, FALSE, '`Option_Default`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Option_Default->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Option_Default->TrueValue = 'Y';
		$this->Option_Default->FalseValue = 'N';
		$this->Option_Default->OptionCount = 2;
		$this->fields['Option_Default'] = &$this->Option_Default;

		// Default_Theme
		$this->Default_Theme = new cField('settings', 'settings', 'x_Default_Theme', 'Default_Theme', '`Default_Theme`', '`Default_Theme`', 200, -1, FALSE, '`Default_Theme`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Default_Theme'] = &$this->Default_Theme;

		// Font_Name
		$this->Font_Name = new cField('settings', 'settings', 'x_Font_Name', 'Font_Name', '`Font_Name`', '`Font_Name`', 200, -1, FALSE, '`Font_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Font_Name->OptionCount = 14;
		$this->fields['Font_Name'] = &$this->Font_Name;

		// Font_Size
		$this->Font_Size = new cField('settings', 'settings', 'x_Font_Size', 'Font_Size', '`Font_Size`', '`Font_Size`', 200, -1, FALSE, '`Font_Size`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Font_Size->OptionCount = 4;
		$this->fields['Font_Size'] = &$this->Font_Size;

		// Show_Border_Layout
		$this->Show_Border_Layout = new cField('settings', 'settings', 'x_Show_Border_Layout', 'Show_Border_Layout', '`Show_Border_Layout`', '`Show_Border_Layout`', 202, -1, FALSE, '`Show_Border_Layout`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Border_Layout->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Border_Layout->TrueValue = 'Y';
		$this->Show_Border_Layout->FalseValue = 'N';
		$this->Show_Border_Layout->OptionCount = 2;
		$this->fields['Show_Border_Layout'] = &$this->Show_Border_Layout;

		// Show_Shadow_Layout
		$this->Show_Shadow_Layout = new cField('settings', 'settings', 'x_Show_Shadow_Layout', 'Show_Shadow_Layout', '`Show_Shadow_Layout`', '`Show_Shadow_Layout`', 202, -1, FALSE, '`Show_Shadow_Layout`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Shadow_Layout->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Shadow_Layout->TrueValue = 'Y';
		$this->Show_Shadow_Layout->FalseValue = 'N';
		$this->Show_Shadow_Layout->OptionCount = 2;
		$this->fields['Show_Shadow_Layout'] = &$this->Show_Shadow_Layout;

		// Menu_Horizontal
		$this->Menu_Horizontal = new cField('settings', 'settings', 'x_Menu_Horizontal', 'Menu_Horizontal', '`Menu_Horizontal`', '`Menu_Horizontal`', 202, -1, FALSE, '`Menu_Horizontal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Menu_Horizontal->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Menu_Horizontal->TrueValue = 'Y';
		$this->Menu_Horizontal->FalseValue = 'N';
		$this->Menu_Horizontal->OptionCount = 2;
		$this->fields['Menu_Horizontal'] = &$this->Menu_Horizontal;

		// Vertical_Menu_Width
		$this->Vertical_Menu_Width = new cField('settings', 'settings', 'x_Vertical_Menu_Width', 'Vertical_Menu_Width', '`Vertical_Menu_Width`', '`Vertical_Menu_Width`', 3, -1, FALSE, '`Vertical_Menu_Width`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Vertical_Menu_Width->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Vertical_Menu_Width'] = &$this->Vertical_Menu_Width;

		// Show_Announcement
		$this->Show_Announcement = new cField('settings', 'settings', 'x_Show_Announcement', 'Show_Announcement', '`Show_Announcement`', '`Show_Announcement`', 202, -1, FALSE, '`Show_Announcement`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Show_Announcement->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Announcement->TrueValue = 'Y';
		$this->Show_Announcement->FalseValue = 'N';
		$this->Show_Announcement->OptionCount = 2;
		$this->fields['Show_Announcement'] = &$this->Show_Announcement;

		// Demo_Mode
		$this->Demo_Mode = new cField('settings', 'settings', 'x_Demo_Mode', 'Demo_Mode', '`Demo_Mode`', '`Demo_Mode`', 202, -1, FALSE, '`Demo_Mode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Demo_Mode->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Demo_Mode->TrueValue = 'Y';
		$this->Demo_Mode->FalseValue = 'N';
		$this->Demo_Mode->OptionCount = 2;
		$this->fields['Demo_Mode'] = &$this->Demo_Mode;

		// Show_Page_Processing_Time
		$this->Show_Page_Processing_Time = new cField('settings', 'settings', 'x_Show_Page_Processing_Time', 'Show_Page_Processing_Time', '`Show_Page_Processing_Time`', '`Show_Page_Processing_Time`', 202, -1, FALSE, '`Show_Page_Processing_Time`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Page_Processing_Time->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Page_Processing_Time->TrueValue = 'Y';
		$this->Show_Page_Processing_Time->FalseValue = 'N';
		$this->Show_Page_Processing_Time->OptionCount = 2;
		$this->fields['Show_Page_Processing_Time'] = &$this->Show_Page_Processing_Time;

		// Allow_User_Preferences
		$this->Allow_User_Preferences = new cField('settings', 'settings', 'x_Allow_User_Preferences', 'Allow_User_Preferences', '`Allow_User_Preferences`', '`Allow_User_Preferences`', 202, -1, FALSE, '`Allow_User_Preferences`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Allow_User_Preferences->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Allow_User_Preferences->TrueValue = 'Y';
		$this->Allow_User_Preferences->FalseValue = 'N';
		$this->Allow_User_Preferences->OptionCount = 2;
		$this->fields['Allow_User_Preferences'] = &$this->Allow_User_Preferences;

		// SMTP_Server
		$this->SMTP_Server = new cField('settings', 'settings', 'x_SMTP_Server', 'SMTP_Server', '`SMTP_Server`', '`SMTP_Server`', 200, -1, FALSE, '`SMTP_Server`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['SMTP_Server'] = &$this->SMTP_Server;

		// SMTP_Server_Port
		$this->SMTP_Server_Port = new cField('settings', 'settings', 'x_SMTP_Server_Port', 'SMTP_Server_Port', '`SMTP_Server_Port`', '`SMTP_Server_Port`', 200, -1, FALSE, '`SMTP_Server_Port`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['SMTP_Server_Port'] = &$this->SMTP_Server_Port;

		// SMTP_Server_Username
		$this->SMTP_Server_Username = new cField('settings', 'settings', 'x_SMTP_Server_Username', 'SMTP_Server_Username', '`SMTP_Server_Username`', '`SMTP_Server_Username`', 200, -1, FALSE, '`SMTP_Server_Username`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['SMTP_Server_Username'] = &$this->SMTP_Server_Username;

		// SMTP_Server_Password
		$this->SMTP_Server_Password = new cField('settings', 'settings', 'x_SMTP_Server_Password', 'SMTP_Server_Password', '`SMTP_Server_Password`', '`SMTP_Server_Password`', 200, -1, FALSE, '`SMTP_Server_Password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['SMTP_Server_Password'] = &$this->SMTP_Server_Password;

		// Sender_Email
		$this->Sender_Email = new cField('settings', 'settings', 'x_Sender_Email', 'Sender_Email', '`Sender_Email`', '`Sender_Email`', 200, -1, FALSE, '`Sender_Email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Sender_Email'] = &$this->Sender_Email;

		// Recipient_Email
		$this->Recipient_Email = new cField('settings', 'settings', 'x_Recipient_Email', 'Recipient_Email', '`Recipient_Email`', '`Recipient_Email`', 200, -1, FALSE, '`Recipient_Email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Recipient_Email'] = &$this->Recipient_Email;

		// Use_Default_Locale
		$this->Use_Default_Locale = new cField('settings', 'settings', 'x_Use_Default_Locale', 'Use_Default_Locale', '`Use_Default_Locale`', '`Use_Default_Locale`', 202, -1, FALSE, '`Use_Default_Locale`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Use_Default_Locale->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Use_Default_Locale->TrueValue = 'Y';
		$this->Use_Default_Locale->FalseValue = 'N';
		$this->Use_Default_Locale->OptionCount = 2;
		$this->fields['Use_Default_Locale'] = &$this->Use_Default_Locale;

		// Default_Language
		$this->Default_Language = new cField('settings', 'settings', 'x_Default_Language', 'Default_Language', '`Default_Language`', '`Default_Language`', 200, -1, FALSE, '`Default_Language`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Default_Language'] = &$this->Default_Language;

		// Default_Timezone
		$this->Default_Timezone = new cField('settings', 'settings', 'x_Default_Timezone', 'Default_Timezone', '`Default_Timezone`', '`Default_Timezone`', 200, -1, FALSE, '`Default_Timezone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Default_Timezone'] = &$this->Default_Timezone;

		// Default_Thousands_Separator
		$this->Default_Thousands_Separator = new cField('settings', 'settings', 'x_Default_Thousands_Separator', 'Default_Thousands_Separator', '`Default_Thousands_Separator`', '`Default_Thousands_Separator`', 200, -1, FALSE, '`Default_Thousands_Separator`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Thousands_Separator'] = &$this->Default_Thousands_Separator;

		// Default_Decimal_Point
		$this->Default_Decimal_Point = new cField('settings', 'settings', 'x_Default_Decimal_Point', 'Default_Decimal_Point', '`Default_Decimal_Point`', '`Default_Decimal_Point`', 200, -1, FALSE, '`Default_Decimal_Point`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Decimal_Point'] = &$this->Default_Decimal_Point;

		// Default_Currency_Symbol
		$this->Default_Currency_Symbol = new cField('settings', 'settings', 'x_Default_Currency_Symbol', 'Default_Currency_Symbol', '`Default_Currency_Symbol`', '`Default_Currency_Symbol`', 200, -1, FALSE, '`Default_Currency_Symbol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Currency_Symbol'] = &$this->Default_Currency_Symbol;

		// Default_Money_Thousands_Separator
		$this->Default_Money_Thousands_Separator = new cField('settings', 'settings', 'x_Default_Money_Thousands_Separator', 'Default_Money_Thousands_Separator', '`Default_Money_Thousands_Separator`', '`Default_Money_Thousands_Separator`', 200, -1, FALSE, '`Default_Money_Thousands_Separator`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Money_Thousands_Separator'] = &$this->Default_Money_Thousands_Separator;

		// Default_Money_Decimal_Point
		$this->Default_Money_Decimal_Point = new cField('settings', 'settings', 'x_Default_Money_Decimal_Point', 'Default_Money_Decimal_Point', '`Default_Money_Decimal_Point`', '`Default_Money_Decimal_Point`', 200, -1, FALSE, '`Default_Money_Decimal_Point`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Money_Decimal_Point'] = &$this->Default_Money_Decimal_Point;

		// Maintenance_Mode
		$this->Maintenance_Mode = new cField('settings', 'settings', 'x_Maintenance_Mode', 'Maintenance_Mode', '`Maintenance_Mode`', '`Maintenance_Mode`', 202, -1, FALSE, '`Maintenance_Mode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Maintenance_Mode->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Maintenance_Mode->TrueValue = 'Y';
		$this->Maintenance_Mode->FalseValue = 'N';
		$this->Maintenance_Mode->OptionCount = 2;
		$this->fields['Maintenance_Mode'] = &$this->Maintenance_Mode;

		// Maintenance_Finish_DateTime
		$this->Maintenance_Finish_DateTime = new cField('settings', 'settings', 'x_Maintenance_Finish_DateTime', 'Maintenance_Finish_DateTime', '`Maintenance_Finish_DateTime`', 'DATE_FORMAT(`Maintenance_Finish_DateTime`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`Maintenance_Finish_DateTime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Maintenance_Finish_DateTime->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Maintenance_Finish_DateTime'] = &$this->Maintenance_Finish_DateTime;

		// Auto_Normal_After_Maintenance
		$this->Auto_Normal_After_Maintenance = new cField('settings', 'settings', 'x_Auto_Normal_After_Maintenance', 'Auto_Normal_After_Maintenance', '`Auto_Normal_After_Maintenance`', '`Auto_Normal_After_Maintenance`', 202, -1, FALSE, '`Auto_Normal_After_Maintenance`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Auto_Normal_After_Maintenance->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Auto_Normal_After_Maintenance->TrueValue = 'Y';
		$this->Auto_Normal_After_Maintenance->FalseValue = 'N';
		$this->Auto_Normal_After_Maintenance->OptionCount = 2;
		$this->fields['Auto_Normal_After_Maintenance'] = &$this->Auto_Normal_After_Maintenance;

		// Allow_User_To_Register
		$this->Allow_User_To_Register = new cField('settings', 'settings', 'x_Allow_User_To_Register', 'Allow_User_To_Register', '`Allow_User_To_Register`', '`Allow_User_To_Register`', 202, -1, FALSE, '`Allow_User_To_Register`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Allow_User_To_Register->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Allow_User_To_Register->TrueValue = 'Y';
		$this->Allow_User_To_Register->FalseValue = 'N';
		$this->Allow_User_To_Register->OptionCount = 2;
		$this->fields['Allow_User_To_Register'] = &$this->Allow_User_To_Register;

		// Suspend_New_User_Account
		$this->Suspend_New_User_Account = new cField('settings', 'settings', 'x_Suspend_New_User_Account', 'Suspend_New_User_Account', '`Suspend_New_User_Account`', '`Suspend_New_User_Account`', 202, -1, FALSE, '`Suspend_New_User_Account`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Suspend_New_User_Account->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Suspend_New_User_Account->TrueValue = 'Y';
		$this->Suspend_New_User_Account->FalseValue = 'N';
		$this->Suspend_New_User_Account->OptionCount = 2;
		$this->fields['Suspend_New_User_Account'] = &$this->Suspend_New_User_Account;

		// User_Need_Activation_After_Registered
		$this->User_Need_Activation_After_Registered = new cField('settings', 'settings', 'x_User_Need_Activation_After_Registered', 'User_Need_Activation_After_Registered', '`User_Need_Activation_After_Registered`', '`User_Need_Activation_After_Registered`', 202, -1, FALSE, '`User_Need_Activation_After_Registered`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->User_Need_Activation_After_Registered->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->User_Need_Activation_After_Registered->TrueValue = 'Y';
		$this->User_Need_Activation_After_Registered->FalseValue = 'N';
		$this->User_Need_Activation_After_Registered->OptionCount = 2;
		$this->fields['User_Need_Activation_After_Registered'] = &$this->User_Need_Activation_After_Registered;

		// Show_Captcha_On_Registration_Page
		$this->Show_Captcha_On_Registration_Page = new cField('settings', 'settings', 'x_Show_Captcha_On_Registration_Page', 'Show_Captcha_On_Registration_Page', '`Show_Captcha_On_Registration_Page`', '`Show_Captcha_On_Registration_Page`', 202, -1, FALSE, '`Show_Captcha_On_Registration_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Captcha_On_Registration_Page->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Captcha_On_Registration_Page->TrueValue = 'Y';
		$this->Show_Captcha_On_Registration_Page->FalseValue = 'N';
		$this->Show_Captcha_On_Registration_Page->OptionCount = 2;
		$this->fields['Show_Captcha_On_Registration_Page'] = &$this->Show_Captcha_On_Registration_Page;

		// Show_Terms_And_Conditions_On_Registration_Page
		$this->Show_Terms_And_Conditions_On_Registration_Page = new cField('settings', 'settings', 'x_Show_Terms_And_Conditions_On_Registration_Page', 'Show_Terms_And_Conditions_On_Registration_Page', '`Show_Terms_And_Conditions_On_Registration_Page`', '`Show_Terms_And_Conditions_On_Registration_Page`', 202, -1, FALSE, '`Show_Terms_And_Conditions_On_Registration_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Terms_And_Conditions_On_Registration_Page->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Terms_And_Conditions_On_Registration_Page->TrueValue = 'Y';
		$this->Show_Terms_And_Conditions_On_Registration_Page->FalseValue = 'N';
		$this->Show_Terms_And_Conditions_On_Registration_Page->OptionCount = 2;
		$this->fields['Show_Terms_And_Conditions_On_Registration_Page'] = &$this->Show_Terms_And_Conditions_On_Registration_Page;

		// User_Auto_Login_After_Activation_Or_Registration
		$this->User_Auto_Login_After_Activation_Or_Registration = new cField('settings', 'settings', 'x_User_Auto_Login_After_Activation_Or_Registration', 'User_Auto_Login_After_Activation_Or_Registration', '`User_Auto_Login_After_Activation_Or_Registration`', '`User_Auto_Login_After_Activation_Or_Registration`', 202, -1, FALSE, '`User_Auto_Login_After_Activation_Or_Registration`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->User_Auto_Login_After_Activation_Or_Registration->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->User_Auto_Login_After_Activation_Or_Registration->TrueValue = 'Y';
		$this->User_Auto_Login_After_Activation_Or_Registration->FalseValue = 'N';
		$this->User_Auto_Login_After_Activation_Or_Registration->OptionCount = 2;
		$this->fields['User_Auto_Login_After_Activation_Or_Registration'] = &$this->User_Auto_Login_After_Activation_Or_Registration;

		// Show_Captcha_On_Login_Page
		$this->Show_Captcha_On_Login_Page = new cField('settings', 'settings', 'x_Show_Captcha_On_Login_Page', 'Show_Captcha_On_Login_Page', '`Show_Captcha_On_Login_Page`', '`Show_Captcha_On_Login_Page`', 202, -1, FALSE, '`Show_Captcha_On_Login_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Captcha_On_Login_Page->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Captcha_On_Login_Page->TrueValue = 'Y';
		$this->Show_Captcha_On_Login_Page->FalseValue = 'N';
		$this->Show_Captcha_On_Login_Page->OptionCount = 2;
		$this->fields['Show_Captcha_On_Login_Page'] = &$this->Show_Captcha_On_Login_Page;

		// Show_Captcha_On_Forgot_Password_Page
		$this->Show_Captcha_On_Forgot_Password_Page = new cField('settings', 'settings', 'x_Show_Captcha_On_Forgot_Password_Page', 'Show_Captcha_On_Forgot_Password_Page', '`Show_Captcha_On_Forgot_Password_Page`', '`Show_Captcha_On_Forgot_Password_Page`', 202, -1, FALSE, '`Show_Captcha_On_Forgot_Password_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Captcha_On_Forgot_Password_Page->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Captcha_On_Forgot_Password_Page->TrueValue = 'Y';
		$this->Show_Captcha_On_Forgot_Password_Page->FalseValue = 'N';
		$this->Show_Captcha_On_Forgot_Password_Page->OptionCount = 2;
		$this->fields['Show_Captcha_On_Forgot_Password_Page'] = &$this->Show_Captcha_On_Forgot_Password_Page;

		// Show_Captcha_On_Change_Password_Page
		$this->Show_Captcha_On_Change_Password_Page = new cField('settings', 'settings', 'x_Show_Captcha_On_Change_Password_Page', 'Show_Captcha_On_Change_Password_Page', '`Show_Captcha_On_Change_Password_Page`', '`Show_Captcha_On_Change_Password_Page`', 202, -1, FALSE, '`Show_Captcha_On_Change_Password_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Captcha_On_Change_Password_Page->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Captcha_On_Change_Password_Page->TrueValue = 'Y';
		$this->Show_Captcha_On_Change_Password_Page->FalseValue = 'N';
		$this->Show_Captcha_On_Change_Password_Page->OptionCount = 2;
		$this->fields['Show_Captcha_On_Change_Password_Page'] = &$this->Show_Captcha_On_Change_Password_Page;

		// User_Auto_Logout_After_Idle_In_Minutes
		$this->User_Auto_Logout_After_Idle_In_Minutes = new cField('settings', 'settings', 'x_User_Auto_Logout_After_Idle_In_Minutes', 'User_Auto_Logout_After_Idle_In_Minutes', '`User_Auto_Logout_After_Idle_In_Minutes`', '`User_Auto_Logout_After_Idle_In_Minutes`', 3, -1, FALSE, '`User_Auto_Logout_After_Idle_In_Minutes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->User_Auto_Logout_After_Idle_In_Minutes->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['User_Auto_Logout_After_Idle_In_Minutes'] = &$this->User_Auto_Logout_After_Idle_In_Minutes;

		// User_Login_Maximum_Retry
		$this->User_Login_Maximum_Retry = new cField('settings', 'settings', 'x_User_Login_Maximum_Retry', 'User_Login_Maximum_Retry', '`User_Login_Maximum_Retry`', '`User_Login_Maximum_Retry`', 3, -1, FALSE, '`User_Login_Maximum_Retry`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->User_Login_Maximum_Retry->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['User_Login_Maximum_Retry'] = &$this->User_Login_Maximum_Retry;

		// User_Login_Retry_Lockout
		$this->User_Login_Retry_Lockout = new cField('settings', 'settings', 'x_User_Login_Retry_Lockout', 'User_Login_Retry_Lockout', '`User_Login_Retry_Lockout`', '`User_Login_Retry_Lockout`', 3, -1, FALSE, '`User_Login_Retry_Lockout`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->User_Login_Retry_Lockout->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['User_Login_Retry_Lockout'] = &$this->User_Login_Retry_Lockout;

		// Redirect_To_Last_Visited_Page_After_Login
		$this->Redirect_To_Last_Visited_Page_After_Login = new cField('settings', 'settings', 'x_Redirect_To_Last_Visited_Page_After_Login', 'Redirect_To_Last_Visited_Page_After_Login', '`Redirect_To_Last_Visited_Page_After_Login`', '`Redirect_To_Last_Visited_Page_After_Login`', 202, -1, FALSE, '`Redirect_To_Last_Visited_Page_After_Login`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Redirect_To_Last_Visited_Page_After_Login->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Redirect_To_Last_Visited_Page_After_Login->TrueValue = 'Y';
		$this->Redirect_To_Last_Visited_Page_After_Login->FalseValue = 'N';
		$this->Redirect_To_Last_Visited_Page_After_Login->OptionCount = 2;
		$this->fields['Redirect_To_Last_Visited_Page_After_Login'] = &$this->Redirect_To_Last_Visited_Page_After_Login;

		// Enable_Password_Expiry
		$this->Enable_Password_Expiry = new cField('settings', 'settings', 'x_Enable_Password_Expiry', 'Enable_Password_Expiry', '`Enable_Password_Expiry`', '`Enable_Password_Expiry`', 202, -1, FALSE, '`Enable_Password_Expiry`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Enable_Password_Expiry->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Enable_Password_Expiry->TrueValue = 'Y';
		$this->Enable_Password_Expiry->FalseValue = 'N';
		$this->Enable_Password_Expiry->OptionCount = 2;
		$this->fields['Enable_Password_Expiry'] = &$this->Enable_Password_Expiry;

		// Password_Expiry_In_Days
		$this->Password_Expiry_In_Days = new cField('settings', 'settings', 'x_Password_Expiry_In_Days', 'Password_Expiry_In_Days', '`Password_Expiry_In_Days`', '`Password_Expiry_In_Days`', 3, -1, FALSE, '`Password_Expiry_In_Days`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Password_Expiry_In_Days->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Password_Expiry_In_Days'] = &$this->Password_Expiry_In_Days;

		// Show_Entire_Header
		$this->Show_Entire_Header = new cField('settings', 'settings', 'x_Show_Entire_Header', 'Show_Entire_Header', '`Show_Entire_Header`', '`Show_Entire_Header`', 202, -1, FALSE, '`Show_Entire_Header`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Entire_Header->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Entire_Header->TrueValue = 'Y';
		$this->Show_Entire_Header->FalseValue = 'N';
		$this->Show_Entire_Header->OptionCount = 2;
		$this->fields['Show_Entire_Header'] = &$this->Show_Entire_Header;

		// Logo_Width
		$this->Logo_Width = new cField('settings', 'settings', 'x_Logo_Width', 'Logo_Width', '`Logo_Width`', '`Logo_Width`', 3, -1, FALSE, '`Logo_Width`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Logo_Width->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Logo_Width'] = &$this->Logo_Width;

		// Show_Site_Title_In_Header
		$this->Show_Site_Title_In_Header = new cField('settings', 'settings', 'x_Show_Site_Title_In_Header', 'Show_Site_Title_In_Header', '`Show_Site_Title_In_Header`', '`Show_Site_Title_In_Header`', 202, -1, FALSE, '`Show_Site_Title_In_Header`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Site_Title_In_Header->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Site_Title_In_Header->TrueValue = 'Y';
		$this->Show_Site_Title_In_Header->FalseValue = 'N';
		$this->Show_Site_Title_In_Header->OptionCount = 2;
		$this->fields['Show_Site_Title_In_Header'] = &$this->Show_Site_Title_In_Header;

		// Show_Current_User_In_Header
		$this->Show_Current_User_In_Header = new cField('settings', 'settings', 'x_Show_Current_User_In_Header', 'Show_Current_User_In_Header', '`Show_Current_User_In_Header`', '`Show_Current_User_In_Header`', 202, -1, FALSE, '`Show_Current_User_In_Header`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Current_User_In_Header->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Current_User_In_Header->TrueValue = 'Y';
		$this->Show_Current_User_In_Header->FalseValue = 'N';
		$this->Show_Current_User_In_Header->OptionCount = 2;
		$this->fields['Show_Current_User_In_Header'] = &$this->Show_Current_User_In_Header;

		// Text_Align_In_Header
		$this->Text_Align_In_Header = new cField('settings', 'settings', 'x_Text_Align_In_Header', 'Text_Align_In_Header', '`Text_Align_In_Header`', '`Text_Align_In_Header`', 202, -1, FALSE, '`Text_Align_In_Header`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Text_Align_In_Header->OptionCount = 3;
		$this->fields['Text_Align_In_Header'] = &$this->Text_Align_In_Header;

		// Site_Title_Text_Style
		$this->Site_Title_Text_Style = new cField('settings', 'settings', 'x_Site_Title_Text_Style', 'Site_Title_Text_Style', '`Site_Title_Text_Style`', '`Site_Title_Text_Style`', 202, -1, FALSE, '`Site_Title_Text_Style`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Site_Title_Text_Style->OptionCount = 3;
		$this->fields['Site_Title_Text_Style'] = &$this->Site_Title_Text_Style;

		// Language_Selector_Visibility
		$this->Language_Selector_Visibility = new cField('settings', 'settings', 'x_Language_Selector_Visibility', 'Language_Selector_Visibility', '`Language_Selector_Visibility`', '`Language_Selector_Visibility`', 202, -1, FALSE, '`Language_Selector_Visibility`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Language_Selector_Visibility->OptionCount = 3;
		$this->fields['Language_Selector_Visibility'] = &$this->Language_Selector_Visibility;

		// Language_Selector_Align
		$this->Language_Selector_Align = new cField('settings', 'settings', 'x_Language_Selector_Align', 'Language_Selector_Align', '`Language_Selector_Align`', '`Language_Selector_Align`', 202, -1, FALSE, '`Language_Selector_Align`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Language_Selector_Align->OptionCount = 4;
		$this->fields['Language_Selector_Align'] = &$this->Language_Selector_Align;

		// Show_Entire_Footer
		$this->Show_Entire_Footer = new cField('settings', 'settings', 'x_Show_Entire_Footer', 'Show_Entire_Footer', '`Show_Entire_Footer`', '`Show_Entire_Footer`', 202, -1, FALSE, '`Show_Entire_Footer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Entire_Footer->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Entire_Footer->TrueValue = 'Y';
		$this->Show_Entire_Footer->FalseValue = 'N';
		$this->Show_Entire_Footer->OptionCount = 2;
		$this->fields['Show_Entire_Footer'] = &$this->Show_Entire_Footer;

		// Show_Text_In_Footer
		$this->Show_Text_In_Footer = new cField('settings', 'settings', 'x_Show_Text_In_Footer', 'Show_Text_In_Footer', '`Show_Text_In_Footer`', '`Show_Text_In_Footer`', 202, -1, FALSE, '`Show_Text_In_Footer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Text_In_Footer->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Text_In_Footer->TrueValue = 'Y';
		$this->Show_Text_In_Footer->FalseValue = 'N';
		$this->Show_Text_In_Footer->OptionCount = 2;
		$this->fields['Show_Text_In_Footer'] = &$this->Show_Text_In_Footer;

		// Show_Back_To_Top_On_Footer
		$this->Show_Back_To_Top_On_Footer = new cField('settings', 'settings', 'x_Show_Back_To_Top_On_Footer', 'Show_Back_To_Top_On_Footer', '`Show_Back_To_Top_On_Footer`', '`Show_Back_To_Top_On_Footer`', 202, -1, FALSE, '`Show_Back_To_Top_On_Footer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Back_To_Top_On_Footer->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Back_To_Top_On_Footer->TrueValue = 'Y';
		$this->Show_Back_To_Top_On_Footer->FalseValue = 'N';
		$this->Show_Back_To_Top_On_Footer->OptionCount = 2;
		$this->fields['Show_Back_To_Top_On_Footer'] = &$this->Show_Back_To_Top_On_Footer;

		// Show_Terms_And_Conditions_On_Footer
		$this->Show_Terms_And_Conditions_On_Footer = new cField('settings', 'settings', 'x_Show_Terms_And_Conditions_On_Footer', 'Show_Terms_And_Conditions_On_Footer', '`Show_Terms_And_Conditions_On_Footer`', '`Show_Terms_And_Conditions_On_Footer`', 202, -1, FALSE, '`Show_Terms_And_Conditions_On_Footer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Terms_And_Conditions_On_Footer->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Terms_And_Conditions_On_Footer->TrueValue = 'Y';
		$this->Show_Terms_And_Conditions_On_Footer->FalseValue = 'N';
		$this->Show_Terms_And_Conditions_On_Footer->OptionCount = 2;
		$this->fields['Show_Terms_And_Conditions_On_Footer'] = &$this->Show_Terms_And_Conditions_On_Footer;

		// Show_About_Us_On_Footer
		$this->Show_About_Us_On_Footer = new cField('settings', 'settings', 'x_Show_About_Us_On_Footer', 'Show_About_Us_On_Footer', '`Show_About_Us_On_Footer`', '`Show_About_Us_On_Footer`', 202, -1, FALSE, '`Show_About_Us_On_Footer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_About_Us_On_Footer->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_About_Us_On_Footer->TrueValue = 'Y';
		$this->Show_About_Us_On_Footer->FalseValue = 'N';
		$this->Show_About_Us_On_Footer->OptionCount = 2;
		$this->fields['Show_About_Us_On_Footer'] = &$this->Show_About_Us_On_Footer;

		// Pagination_Position
		$this->Pagination_Position = new cField('settings', 'settings', 'x_Pagination_Position', 'Pagination_Position', '`Pagination_Position`', '`Pagination_Position`', 202, -1, FALSE, '`Pagination_Position`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Pagination_Position->OptionCount = 3;
		$this->fields['Pagination_Position'] = &$this->Pagination_Position;

		// Pagination_Style
		$this->Pagination_Style = new cField('settings', 'settings', 'x_Pagination_Style', 'Pagination_Style', '`Pagination_Style`', '`Pagination_Style`', 202, -1, FALSE, '`Pagination_Style`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Pagination_Style->OptionCount = 2;
		$this->fields['Pagination_Style'] = &$this->Pagination_Style;

		// Selectable_Records_Per_Page
		$this->Selectable_Records_Per_Page = new cField('settings', 'settings', 'x_Selectable_Records_Per_Page', 'Selectable_Records_Per_Page', '`Selectable_Records_Per_Page`', '`Selectable_Records_Per_Page`', 200, -1, FALSE, '`Selectable_Records_Per_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Selectable_Records_Per_Page'] = &$this->Selectable_Records_Per_Page;

		// Selectable_Groups_Per_Page
		$this->Selectable_Groups_Per_Page = new cField('settings', 'settings', 'x_Selectable_Groups_Per_Page', 'Selectable_Groups_Per_Page', '`Selectable_Groups_Per_Page`', '`Selectable_Groups_Per_Page`', 200, -1, FALSE, '`Selectable_Groups_Per_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Selectable_Groups_Per_Page'] = &$this->Selectable_Groups_Per_Page;

		// Default_Record_Per_Page
		$this->Default_Record_Per_Page = new cField('settings', 'settings', 'x_Default_Record_Per_Page', 'Default_Record_Per_Page', '`Default_Record_Per_Page`', '`Default_Record_Per_Page`', 3, -1, FALSE, '`Default_Record_Per_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Default_Record_Per_Page->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Default_Record_Per_Page'] = &$this->Default_Record_Per_Page;

		// Default_Group_Per_Page
		$this->Default_Group_Per_Page = new cField('settings', 'settings', 'x_Default_Group_Per_Page', 'Default_Group_Per_Page', '`Default_Group_Per_Page`', '`Default_Group_Per_Page`', 3, -1, FALSE, '`Default_Group_Per_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Default_Group_Per_Page->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Default_Group_Per_Page'] = &$this->Default_Group_Per_Page;

		// Maximum_Selected_Records
		$this->Maximum_Selected_Records = new cField('settings', 'settings', 'x_Maximum_Selected_Records', 'Maximum_Selected_Records', '`Maximum_Selected_Records`', '`Maximum_Selected_Records`', 3, -1, FALSE, '`Maximum_Selected_Records`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Maximum_Selected_Records->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Maximum_Selected_Records'] = &$this->Maximum_Selected_Records;

		// Maximum_Selected_Groups
		$this->Maximum_Selected_Groups = new cField('settings', 'settings', 'x_Maximum_Selected_Groups', 'Maximum_Selected_Groups', '`Maximum_Selected_Groups`', '`Maximum_Selected_Groups`', 3, -1, FALSE, '`Maximum_Selected_Groups`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Maximum_Selected_Groups->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Maximum_Selected_Groups'] = &$this->Maximum_Selected_Groups;

		// Show_PageNum_If_Record_Not_Over_Pagesize
		$this->Show_PageNum_If_Record_Not_Over_Pagesize = new cField('settings', 'settings', 'x_Show_PageNum_If_Record_Not_Over_Pagesize', 'Show_PageNum_If_Record_Not_Over_Pagesize', '`Show_PageNum_If_Record_Not_Over_Pagesize`', '`Show_PageNum_If_Record_Not_Over_Pagesize`', 202, -1, FALSE, '`Show_PageNum_If_Record_Not_Over_Pagesize`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->TrueValue = 'Y';
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->FalseValue = 'N';
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->OptionCount = 2;
		$this->fields['Show_PageNum_If_Record_Not_Over_Pagesize'] = &$this->Show_PageNum_If_Record_Not_Over_Pagesize;

		// Table_Width_Style
		$this->Table_Width_Style = new cField('settings', 'settings', 'x_Table_Width_Style', 'Table_Width_Style', '`Table_Width_Style`', '`Table_Width_Style`', 202, -1, FALSE, '`Table_Width_Style`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Table_Width_Style->OptionCount = 3;
		$this->fields['Table_Width_Style'] = &$this->Table_Width_Style;

		// Scroll_Table_Width
		$this->Scroll_Table_Width = new cField('settings', 'settings', 'x_Scroll_Table_Width', 'Scroll_Table_Width', '`Scroll_Table_Width`', '`Scroll_Table_Width`', 3, -1, FALSE, '`Scroll_Table_Width`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Scroll_Table_Width->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Scroll_Table_Width'] = &$this->Scroll_Table_Width;

		// Scroll_Table_Height
		$this->Scroll_Table_Height = new cField('settings', 'settings', 'x_Scroll_Table_Height', 'Scroll_Table_Height', '`Scroll_Table_Height`', '`Scroll_Table_Height`', 3, -1, FALSE, '`Scroll_Table_Height`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Scroll_Table_Height->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Scroll_Table_Height'] = &$this->Scroll_Table_Height;

		// Search_Panel_Collapsed
		$this->Search_Panel_Collapsed = new cField('settings', 'settings', 'x_Search_Panel_Collapsed', 'Search_Panel_Collapsed', '`Search_Panel_Collapsed`', '`Search_Panel_Collapsed`', 202, -1, FALSE, '`Search_Panel_Collapsed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Search_Panel_Collapsed->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Search_Panel_Collapsed->TrueValue = 'Y';
		$this->Search_Panel_Collapsed->FalseValue = 'N';
		$this->Search_Panel_Collapsed->OptionCount = 2;
		$this->fields['Search_Panel_Collapsed'] = &$this->Search_Panel_Collapsed;

		// Filter_Panel_Collapsed
		$this->Filter_Panel_Collapsed = new cField('settings', 'settings', 'x_Filter_Panel_Collapsed', 'Filter_Panel_Collapsed', '`Filter_Panel_Collapsed`', '`Filter_Panel_Collapsed`', 202, -1, FALSE, '`Filter_Panel_Collapsed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Filter_Panel_Collapsed->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Filter_Panel_Collapsed->TrueValue = 'Y';
		$this->Filter_Panel_Collapsed->FalseValue = 'N';
		$this->Filter_Panel_Collapsed->OptionCount = 2;
		$this->fields['Filter_Panel_Collapsed'] = &$this->Filter_Panel_Collapsed;

		// Show_Record_Number_On_List_Page
		$this->Show_Record_Number_On_List_Page = new cField('settings', 'settings', 'x_Show_Record_Number_On_List_Page', 'Show_Record_Number_On_List_Page', '`Show_Record_Number_On_List_Page`', '`Show_Record_Number_On_List_Page`', 202, -1, FALSE, '`Show_Record_Number_On_List_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Record_Number_On_List_Page->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Record_Number_On_List_Page->TrueValue = 'Y';
		$this->Show_Record_Number_On_List_Page->FalseValue = 'N';
		$this->Show_Record_Number_On_List_Page->OptionCount = 2;
		$this->fields['Show_Record_Number_On_List_Page'] = &$this->Show_Record_Number_On_List_Page;

		// Show_Empty_Table_On_List_Page
		$this->Show_Empty_Table_On_List_Page = new cField('settings', 'settings', 'x_Show_Empty_Table_On_List_Page', 'Show_Empty_Table_On_List_Page', '`Show_Empty_Table_On_List_Page`', '`Show_Empty_Table_On_List_Page`', 202, -1, FALSE, '`Show_Empty_Table_On_List_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Empty_Table_On_List_Page->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Empty_Table_On_List_Page->TrueValue = 'Y';
		$this->Show_Empty_Table_On_List_Page->FalseValue = 'N';
		$this->Show_Empty_Table_On_List_Page->OptionCount = 2;
		$this->fields['Show_Empty_Table_On_List_Page'] = &$this->Show_Empty_Table_On_List_Page;

		// Rows_Vertical_Align_Top
		$this->Rows_Vertical_Align_Top = new cField('settings', 'settings', 'x_Rows_Vertical_Align_Top', 'Rows_Vertical_Align_Top', '`Rows_Vertical_Align_Top`', '`Rows_Vertical_Align_Top`', 202, -1, FALSE, '`Rows_Vertical_Align_Top`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Rows_Vertical_Align_Top->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Rows_Vertical_Align_Top->TrueValue = 'Y';
		$this->Rows_Vertical_Align_Top->FalseValue = 'N';
		$this->Rows_Vertical_Align_Top->OptionCount = 2;
		$this->fields['Rows_Vertical_Align_Top'] = &$this->Rows_Vertical_Align_Top;

		// Action_Button_Alignment
		$this->Action_Button_Alignment = new cField('settings', 'settings', 'x_Action_Button_Alignment', 'Action_Button_Alignment', '`Action_Button_Alignment`', '`Action_Button_Alignment`', 202, -1, FALSE, '`Action_Button_Alignment`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Action_Button_Alignment->OptionCount = 2;
		$this->fields['Action_Button_Alignment'] = &$this->Action_Button_Alignment;

		// Show_Add_Success_Message
		$this->Show_Add_Success_Message = new cField('settings', 'settings', 'x_Show_Add_Success_Message', 'Show_Add_Success_Message', '`Show_Add_Success_Message`', '`Show_Add_Success_Message`', 202, -1, FALSE, '`Show_Add_Success_Message`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Add_Success_Message->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Add_Success_Message->TrueValue = 'Y';
		$this->Show_Add_Success_Message->FalseValue = 'N';
		$this->Show_Add_Success_Message->OptionCount = 2;
		$this->fields['Show_Add_Success_Message'] = &$this->Show_Add_Success_Message;

		// Show_Edit_Success_Message
		$this->Show_Edit_Success_Message = new cField('settings', 'settings', 'x_Show_Edit_Success_Message', 'Show_Edit_Success_Message', '`Show_Edit_Success_Message`', '`Show_Edit_Success_Message`', 202, -1, FALSE, '`Show_Edit_Success_Message`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Edit_Success_Message->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Edit_Success_Message->TrueValue = 'Y';
		$this->Show_Edit_Success_Message->FalseValue = 'N';
		$this->Show_Edit_Success_Message->OptionCount = 2;
		$this->fields['Show_Edit_Success_Message'] = &$this->Show_Edit_Success_Message;

		// jQuery_Auto_Hide_Success_Message
		$this->jQuery_Auto_Hide_Success_Message = new cField('settings', 'settings', 'x_jQuery_Auto_Hide_Success_Message', 'jQuery_Auto_Hide_Success_Message', '`jQuery_Auto_Hide_Success_Message`', '`jQuery_Auto_Hide_Success_Message`', 202, -1, FALSE, '`jQuery_Auto_Hide_Success_Message`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->jQuery_Auto_Hide_Success_Message->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->jQuery_Auto_Hide_Success_Message->TrueValue = 'Y';
		$this->jQuery_Auto_Hide_Success_Message->FalseValue = 'N';
		$this->jQuery_Auto_Hide_Success_Message->OptionCount = 2;
		$this->fields['jQuery_Auto_Hide_Success_Message'] = &$this->jQuery_Auto_Hide_Success_Message;

		// Use_Javascript_Message
		$this->Use_Javascript_Message = new cField('settings', 'settings', 'x_Use_Javascript_Message', 'Use_Javascript_Message', '`Use_Javascript_Message`', '`Use_Javascript_Message`', 202, -1, FALSE, '`Use_Javascript_Message`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Use_Javascript_Message->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Use_Javascript_Message->OptionCount = 2;
		$this->fields['Use_Javascript_Message'] = &$this->Use_Javascript_Message;

		// Login_Window_Type
		$this->Login_Window_Type = new cField('settings', 'settings', 'x_Login_Window_Type', 'Login_Window_Type', '`Login_Window_Type`', '`Login_Window_Type`', 202, -1, FALSE, '`Login_Window_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Login_Window_Type->OptionCount = 2;
		$this->fields['Login_Window_Type'] = &$this->Login_Window_Type;

		// Forgot_Password_Window_Type
		$this->Forgot_Password_Window_Type = new cField('settings', 'settings', 'x_Forgot_Password_Window_Type', 'Forgot_Password_Window_Type', '`Forgot_Password_Window_Type`', '`Forgot_Password_Window_Type`', 202, -1, FALSE, '`Forgot_Password_Window_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Forgot_Password_Window_Type->OptionCount = 2;
		$this->fields['Forgot_Password_Window_Type'] = &$this->Forgot_Password_Window_Type;

		// Change_Password_Window_Type
		$this->Change_Password_Window_Type = new cField('settings', 'settings', 'x_Change_Password_Window_Type', 'Change_Password_Window_Type', '`Change_Password_Window_Type`', '`Change_Password_Window_Type`', 202, -1, FALSE, '`Change_Password_Window_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Change_Password_Window_Type->OptionCount = 2;
		$this->fields['Change_Password_Window_Type'] = &$this->Change_Password_Window_Type;

		// Registration_Window_Type
		$this->Registration_Window_Type = new cField('settings', 'settings', 'x_Registration_Window_Type', 'Registration_Window_Type', '`Registration_Window_Type`', '`Registration_Window_Type`', 202, -1, FALSE, '`Registration_Window_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Registration_Window_Type->OptionCount = 2;
		$this->fields['Registration_Window_Type'] = &$this->Registration_Window_Type;

		// Show_Record_Number_On_Detail_Preview
		$this->Show_Record_Number_On_Detail_Preview = new cField('settings', 'settings', 'x_Show_Record_Number_On_Detail_Preview', 'Show_Record_Number_On_Detail_Preview', '`Show_Record_Number_On_Detail_Preview`', '`Show_Record_Number_On_Detail_Preview`', 202, -1, FALSE, '`Show_Record_Number_On_Detail_Preview`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Record_Number_On_Detail_Preview->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Record_Number_On_Detail_Preview->TrueValue = 'Y';
		$this->Show_Record_Number_On_Detail_Preview->FalseValue = 'N';
		$this->Show_Record_Number_On_Detail_Preview->OptionCount = 2;
		$this->fields['Show_Record_Number_On_Detail_Preview'] = &$this->Show_Record_Number_On_Detail_Preview;

		// Show_Empty_Table_In_Detail_Preview
		$this->Show_Empty_Table_In_Detail_Preview = new cField('settings', 'settings', 'x_Show_Empty_Table_In_Detail_Preview', 'Show_Empty_Table_In_Detail_Preview', '`Show_Empty_Table_In_Detail_Preview`', '`Show_Empty_Table_In_Detail_Preview`', 202, -1, FALSE, '`Show_Empty_Table_In_Detail_Preview`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Empty_Table_In_Detail_Preview->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Empty_Table_In_Detail_Preview->TrueValue = 'Y';
		$this->Show_Empty_Table_In_Detail_Preview->FalseValue = 'N';
		$this->Show_Empty_Table_In_Detail_Preview->OptionCount = 2;
		$this->fields['Show_Empty_Table_In_Detail_Preview'] = &$this->Show_Empty_Table_In_Detail_Preview;

		// Detail_Preview_Table_Width
		$this->Detail_Preview_Table_Width = new cField('settings', 'settings', 'x_Detail_Preview_Table_Width', 'Detail_Preview_Table_Width', '`Detail_Preview_Table_Width`', '`Detail_Preview_Table_Width`', 3, -1, FALSE, '`Detail_Preview_Table_Width`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Detail_Preview_Table_Width->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Detail_Preview_Table_Width'] = &$this->Detail_Preview_Table_Width;

		// Password_Minimum_Length
		$this->Password_Minimum_Length = new cField('settings', 'settings', 'x_Password_Minimum_Length', 'Password_Minimum_Length', '`Password_Minimum_Length`', '`Password_Minimum_Length`', 3, -1, FALSE, '`Password_Minimum_Length`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Password_Minimum_Length->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Password_Minimum_Length'] = &$this->Password_Minimum_Length;

		// Password_Maximum_Length
		$this->Password_Maximum_Length = new cField('settings', 'settings', 'x_Password_Maximum_Length', 'Password_Maximum_Length', '`Password_Maximum_Length`', '`Password_Maximum_Length`', 3, -1, FALSE, '`Password_Maximum_Length`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Password_Maximum_Length->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Password_Maximum_Length'] = &$this->Password_Maximum_Length;

		// Password_Must_Contain_At_Least_One_Lower_Case
		$this->Password_Must_Contain_At_Least_One_Lower_Case = new cField('settings', 'settings', 'x_Password_Must_Contain_At_Least_One_Lower_Case', 'Password_Must_Contain_At_Least_One_Lower_Case', '`Password_Must_Contain_At_Least_One_Lower_Case`', '`Password_Must_Contain_At_Least_One_Lower_Case`', 202, -1, FALSE, '`Password_Must_Contain_At_Least_One_Lower_Case`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Password_Must_Contain_At_Least_One_Lower_Case->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Password_Must_Contain_At_Least_One_Lower_Case->TrueValue = 'Y';
		$this->Password_Must_Contain_At_Least_One_Lower_Case->FalseValue = 'N';
		$this->Password_Must_Contain_At_Least_One_Lower_Case->OptionCount = 2;
		$this->fields['Password_Must_Contain_At_Least_One_Lower_Case'] = &$this->Password_Must_Contain_At_Least_One_Lower_Case;

		// Password_Must_Comply_With_Minumum_Length
		$this->Password_Must_Comply_With_Minumum_Length = new cField('settings', 'settings', 'x_Password_Must_Comply_With_Minumum_Length', 'Password_Must_Comply_With_Minumum_Length', '`Password_Must_Comply_With_Minumum_Length`', '`Password_Must_Comply_With_Minumum_Length`', 202, -1, FALSE, '`Password_Must_Comply_With_Minumum_Length`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Password_Must_Comply_With_Minumum_Length->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Password_Must_Comply_With_Minumum_Length->TrueValue = 'Y';
		$this->Password_Must_Comply_With_Minumum_Length->FalseValue = 'N';
		$this->Password_Must_Comply_With_Minumum_Length->OptionCount = 2;
		$this->fields['Password_Must_Comply_With_Minumum_Length'] = &$this->Password_Must_Comply_With_Minumum_Length;

		// Password_Must_Comply_With_Maximum_Length
		$this->Password_Must_Comply_With_Maximum_Length = new cField('settings', 'settings', 'x_Password_Must_Comply_With_Maximum_Length', 'Password_Must_Comply_With_Maximum_Length', '`Password_Must_Comply_With_Maximum_Length`', '`Password_Must_Comply_With_Maximum_Length`', 202, -1, FALSE, '`Password_Must_Comply_With_Maximum_Length`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Password_Must_Comply_With_Maximum_Length->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Password_Must_Comply_With_Maximum_Length->TrueValue = 'Y';
		$this->Password_Must_Comply_With_Maximum_Length->FalseValue = 'N';
		$this->Password_Must_Comply_With_Maximum_Length->OptionCount = 2;
		$this->fields['Password_Must_Comply_With_Maximum_Length'] = &$this->Password_Must_Comply_With_Maximum_Length;

		// Password_Must_Contain_At_Least_One_Upper_Case
		$this->Password_Must_Contain_At_Least_One_Upper_Case = new cField('settings', 'settings', 'x_Password_Must_Contain_At_Least_One_Upper_Case', 'Password_Must_Contain_At_Least_One_Upper_Case', '`Password_Must_Contain_At_Least_One_Upper_Case`', '`Password_Must_Contain_At_Least_One_Upper_Case`', 202, -1, FALSE, '`Password_Must_Contain_At_Least_One_Upper_Case`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Password_Must_Contain_At_Least_One_Upper_Case->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Password_Must_Contain_At_Least_One_Upper_Case->TrueValue = 'Y';
		$this->Password_Must_Contain_At_Least_One_Upper_Case->FalseValue = 'N';
		$this->Password_Must_Contain_At_Least_One_Upper_Case->OptionCount = 2;
		$this->fields['Password_Must_Contain_At_Least_One_Upper_Case'] = &$this->Password_Must_Contain_At_Least_One_Upper_Case;

		// Password_Must_Contain_At_Least_One_Numeric
		$this->Password_Must_Contain_At_Least_One_Numeric = new cField('settings', 'settings', 'x_Password_Must_Contain_At_Least_One_Numeric', 'Password_Must_Contain_At_Least_One_Numeric', '`Password_Must_Contain_At_Least_One_Numeric`', '`Password_Must_Contain_At_Least_One_Numeric`', 202, -1, FALSE, '`Password_Must_Contain_At_Least_One_Numeric`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Password_Must_Contain_At_Least_One_Numeric->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Password_Must_Contain_At_Least_One_Numeric->TrueValue = 'Y';
		$this->Password_Must_Contain_At_Least_One_Numeric->FalseValue = 'N';
		$this->Password_Must_Contain_At_Least_One_Numeric->OptionCount = 2;
		$this->fields['Password_Must_Contain_At_Least_One_Numeric'] = &$this->Password_Must_Contain_At_Least_One_Numeric;

		// Password_Must_Contain_At_Least_One_Symbol
		$this->Password_Must_Contain_At_Least_One_Symbol = new cField('settings', 'settings', 'x_Password_Must_Contain_At_Least_One_Symbol', 'Password_Must_Contain_At_Least_One_Symbol', '`Password_Must_Contain_At_Least_One_Symbol`', '`Password_Must_Contain_At_Least_One_Symbol`', 202, -1, FALSE, '`Password_Must_Contain_At_Least_One_Symbol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Password_Must_Contain_At_Least_One_Symbol->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Password_Must_Contain_At_Least_One_Symbol->TrueValue = 'Y';
		$this->Password_Must_Contain_At_Least_One_Symbol->FalseValue = 'N';
		$this->Password_Must_Contain_At_Least_One_Symbol->OptionCount = 2;
		$this->fields['Password_Must_Contain_At_Least_One_Symbol'] = &$this->Password_Must_Contain_At_Least_One_Symbol;

		// Password_Must_Be_Difference_Between_Old_And_New
		$this->Password_Must_Be_Difference_Between_Old_And_New = new cField('settings', 'settings', 'x_Password_Must_Be_Difference_Between_Old_And_New', 'Password_Must_Be_Difference_Between_Old_And_New', '`Password_Must_Be_Difference_Between_Old_And_New`', '`Password_Must_Be_Difference_Between_Old_And_New`', 202, -1, FALSE, '`Password_Must_Be_Difference_Between_Old_And_New`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Password_Must_Be_Difference_Between_Old_And_New->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Password_Must_Be_Difference_Between_Old_And_New->TrueValue = 'Y';
		$this->Password_Must_Be_Difference_Between_Old_And_New->FalseValue = 'N';
		$this->Password_Must_Be_Difference_Between_Old_And_New->OptionCount = 2;
		$this->fields['Password_Must_Be_Difference_Between_Old_And_New'] = &$this->Password_Must_Be_Difference_Between_Old_And_New;

		// Reset_Password_Field_Options
		$this->Reset_Password_Field_Options = new cField('settings', 'settings', 'x_Reset_Password_Field_Options', 'Reset_Password_Field_Options', '`Reset_Password_Field_Options`', '`Reset_Password_Field_Options`', 202, -1, FALSE, '`Reset_Password_Field_Options`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Reset_Password_Field_Options->OptionCount = 3;
		$this->fields['Reset_Password_Field_Options'] = &$this->Reset_Password_Field_Options;

		// Export_Record_Options
		$this->Export_Record_Options = new cField('settings', 'settings', 'x_Export_Record_Options', 'Export_Record_Options', '`Export_Record_Options`', '`Export_Record_Options`', 202, -1, FALSE, '`Export_Record_Options`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Export_Record_Options->OptionCount = 3;
		$this->fields['Export_Record_Options'] = &$this->Export_Record_Options;

		// Show_Record_Number_On_Exported_List_Page
		$this->Show_Record_Number_On_Exported_List_Page = new cField('settings', 'settings', 'x_Show_Record_Number_On_Exported_List_Page', 'Show_Record_Number_On_Exported_List_Page', '`Show_Record_Number_On_Exported_List_Page`', '`Show_Record_Number_On_Exported_List_Page`', 202, -1, FALSE, '`Show_Record_Number_On_Exported_List_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Show_Record_Number_On_Exported_List_Page->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Show_Record_Number_On_Exported_List_Page->TrueValue = 'Y';
		$this->Show_Record_Number_On_Exported_List_Page->FalseValue = 'N';
		$this->Show_Record_Number_On_Exported_List_Page->OptionCount = 2;
		$this->fields['Show_Record_Number_On_Exported_List_Page'] = &$this->Show_Record_Number_On_Exported_List_Page;

		// Use_Table_Setting_For_Export_Field_Caption
		$this->Use_Table_Setting_For_Export_Field_Caption = new cField('settings', 'settings', 'x_Use_Table_Setting_For_Export_Field_Caption', 'Use_Table_Setting_For_Export_Field_Caption', '`Use_Table_Setting_For_Export_Field_Caption`', '`Use_Table_Setting_For_Export_Field_Caption`', 202, -1, FALSE, '`Use_Table_Setting_For_Export_Field_Caption`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Use_Table_Setting_For_Export_Field_Caption->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Use_Table_Setting_For_Export_Field_Caption->TrueValue = 'Y';
		$this->Use_Table_Setting_For_Export_Field_Caption->FalseValue = 'N';
		$this->Use_Table_Setting_For_Export_Field_Caption->OptionCount = 2;
		$this->fields['Use_Table_Setting_For_Export_Field_Caption'] = &$this->Use_Table_Setting_For_Export_Field_Caption;

		// Use_Table_Setting_For_Export_Original_Value
		$this->Use_Table_Setting_For_Export_Original_Value = new cField('settings', 'settings', 'x_Use_Table_Setting_For_Export_Original_Value', 'Use_Table_Setting_For_Export_Original_Value', '`Use_Table_Setting_For_Export_Original_Value`', '`Use_Table_Setting_For_Export_Original_Value`', 202, -1, FALSE, '`Use_Table_Setting_For_Export_Original_Value`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Use_Table_Setting_For_Export_Original_Value->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Use_Table_Setting_For_Export_Original_Value->TrueValue = 'Y';
		$this->Use_Table_Setting_For_Export_Original_Value->FalseValue = 'N';
		$this->Use_Table_Setting_For_Export_Original_Value->OptionCount = 2;
		$this->fields['Use_Table_Setting_For_Export_Original_Value'] = &$this->Use_Table_Setting_For_Export_Original_Value;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`settings`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('Option_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('Option_ID', $this->DBID) . '=' . ew_QuotedValue($rs['Option_ID'], $this->Option_ID->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`Option_ID` = @Option_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Option_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Option_ID@", ew_AdjustSql($this->Option_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "settingslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "settingslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("settingsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("settingsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "settingsadd.php?" . $this->UrlParm($parm);
		else
			$url = "settingsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("settingsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("settingsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("settingsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Option_ID:" . ew_VarToJson($this->Option_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Option_ID->CurrentValue)) {
			$sUrl .= "Option_ID=" . urlencode($this->Option_ID->CurrentValue);
		} else {
			return "javascript:alertify.alert(ewLanguage.Phrase('InvalidRecord'), function (ok) { }).set('title', ewLanguage.Phrase('AlertifyAlert'));"; // Modification Alertify by Masino Sinaga, October 14, 2013
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["Option_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["Option_ID"]);
			elseif (isset($_GET["Option_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["Option_ID"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->Option_ID->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Option_ID
		$this->Option_ID->EditAttrs["class"] = "form-control";
		$this->Option_ID->EditCustomAttributes = "";
		$this->Option_ID->EditValue = $this->Option_ID->CurrentValue;
		$this->Option_ID->ViewCustomAttributes = "";

		// Option_Default
		$this->Option_Default->EditCustomAttributes = "";
		$this->Option_Default->EditValue = $this->Option_Default->Options(FALSE);

		// Default_Theme
		$this->Default_Theme->EditAttrs["class"] = "form-control";
		$this->Default_Theme->EditCustomAttributes = "";

		// Font_Name
		$this->Font_Name->EditAttrs["class"] = "form-control";
		$this->Font_Name->EditCustomAttributes = "";
		$this->Font_Name->EditValue = $this->Font_Name->Options(TRUE);

		// Font_Size
		$this->Font_Size->EditAttrs["class"] = "form-control";
		$this->Font_Size->EditCustomAttributes = "";
		$this->Font_Size->EditValue = $this->Font_Size->Options(TRUE);

		// Show_Border_Layout
		$this->Show_Border_Layout->EditCustomAttributes = "";
		$this->Show_Border_Layout->EditValue = $this->Show_Border_Layout->Options(FALSE);

		// Show_Shadow_Layout
		$this->Show_Shadow_Layout->EditCustomAttributes = "";
		$this->Show_Shadow_Layout->EditValue = $this->Show_Shadow_Layout->Options(FALSE);

		// Menu_Horizontal
		$this->Menu_Horizontal->EditCustomAttributes = "";
		$this->Menu_Horizontal->EditValue = $this->Menu_Horizontal->Options(FALSE);

		// Vertical_Menu_Width
		$this->Vertical_Menu_Width->EditAttrs["class"] = "form-control";
		$this->Vertical_Menu_Width->EditCustomAttributes = "";
		$this->Vertical_Menu_Width->EditValue = $this->Vertical_Menu_Width->CurrentValue;
		$this->Vertical_Menu_Width->PlaceHolder = ew_RemoveHtml($this->Vertical_Menu_Width->FldCaption());

		// Show_Announcement
		$this->Show_Announcement->EditAttrs["class"] = "form-control";
		$this->Show_Announcement->EditCustomAttributes = "";
		$this->Show_Announcement->EditValue = $this->Show_Announcement->Options(TRUE);

		// Demo_Mode
		$this->Demo_Mode->EditCustomAttributes = "";
		$this->Demo_Mode->EditValue = $this->Demo_Mode->Options(FALSE);

		// Show_Page_Processing_Time
		$this->Show_Page_Processing_Time->EditCustomAttributes = "";
		$this->Show_Page_Processing_Time->EditValue = $this->Show_Page_Processing_Time->Options(FALSE);

		// Allow_User_Preferences
		$this->Allow_User_Preferences->EditCustomAttributes = "";
		$this->Allow_User_Preferences->EditValue = $this->Allow_User_Preferences->Options(FALSE);

		// SMTP_Server
		$this->SMTP_Server->EditAttrs["class"] = "form-control";
		$this->SMTP_Server->EditCustomAttributes = "";
		$this->SMTP_Server->EditValue = $this->SMTP_Server->CurrentValue;
		$this->SMTP_Server->PlaceHolder = ew_RemoveHtml($this->SMTP_Server->FldCaption());

		// SMTP_Server_Port
		$this->SMTP_Server_Port->EditAttrs["class"] = "form-control";
		$this->SMTP_Server_Port->EditCustomAttributes = "";
		$this->SMTP_Server_Port->EditValue = $this->SMTP_Server_Port->CurrentValue;
		$this->SMTP_Server_Port->PlaceHolder = ew_RemoveHtml($this->SMTP_Server_Port->FldCaption());

		// SMTP_Server_Username
		$this->SMTP_Server_Username->EditAttrs["class"] = "form-control";
		$this->SMTP_Server_Username->EditCustomAttributes = "";
		$this->SMTP_Server_Username->EditValue = $this->SMTP_Server_Username->CurrentValue;
		$this->SMTP_Server_Username->PlaceHolder = ew_RemoveHtml($this->SMTP_Server_Username->FldCaption());

		// SMTP_Server_Password
		$this->SMTP_Server_Password->EditAttrs["class"] = "form-control";
		$this->SMTP_Server_Password->EditCustomAttributes = "";
		$this->SMTP_Server_Password->EditValue = $this->SMTP_Server_Password->CurrentValue;
		$this->SMTP_Server_Password->PlaceHolder = ew_RemoveHtml($this->SMTP_Server_Password->FldCaption());

		// Sender_Email
		$this->Sender_Email->EditAttrs["class"] = "form-control";
		$this->Sender_Email->EditCustomAttributes = "";
		$this->Sender_Email->EditValue = $this->Sender_Email->CurrentValue;
		$this->Sender_Email->PlaceHolder = ew_RemoveHtml($this->Sender_Email->FldCaption());

		// Recipient_Email
		$this->Recipient_Email->EditAttrs["class"] = "form-control";
		$this->Recipient_Email->EditCustomAttributes = "";
		$this->Recipient_Email->EditValue = $this->Recipient_Email->CurrentValue;
		$this->Recipient_Email->PlaceHolder = ew_RemoveHtml($this->Recipient_Email->FldCaption());

		// Use_Default_Locale
		$this->Use_Default_Locale->EditCustomAttributes = "";
		$this->Use_Default_Locale->EditValue = $this->Use_Default_Locale->Options(FALSE);

		// Default_Language
		$this->Default_Language->EditAttrs["class"] = "form-control";
		$this->Default_Language->EditCustomAttributes = "";

		// Default_Timezone
		$this->Default_Timezone->EditAttrs["class"] = "form-control";
		$this->Default_Timezone->EditCustomAttributes = "";

		// Default_Thousands_Separator
		$this->Default_Thousands_Separator->EditAttrs["class"] = "form-control";
		$this->Default_Thousands_Separator->EditCustomAttributes = "";
		$this->Default_Thousands_Separator->EditValue = $this->Default_Thousands_Separator->CurrentValue;
		$this->Default_Thousands_Separator->PlaceHolder = ew_RemoveHtml($this->Default_Thousands_Separator->FldCaption());

		// Default_Decimal_Point
		$this->Default_Decimal_Point->EditAttrs["class"] = "form-control";
		$this->Default_Decimal_Point->EditCustomAttributes = "";
		$this->Default_Decimal_Point->EditValue = $this->Default_Decimal_Point->CurrentValue;
		$this->Default_Decimal_Point->PlaceHolder = ew_RemoveHtml($this->Default_Decimal_Point->FldCaption());

		// Default_Currency_Symbol
		$this->Default_Currency_Symbol->EditAttrs["class"] = "form-control";
		$this->Default_Currency_Symbol->EditCustomAttributes = "";
		$this->Default_Currency_Symbol->EditValue = $this->Default_Currency_Symbol->CurrentValue;
		$this->Default_Currency_Symbol->PlaceHolder = ew_RemoveHtml($this->Default_Currency_Symbol->FldCaption());

		// Default_Money_Thousands_Separator
		$this->Default_Money_Thousands_Separator->EditAttrs["class"] = "form-control";
		$this->Default_Money_Thousands_Separator->EditCustomAttributes = "";
		$this->Default_Money_Thousands_Separator->EditValue = $this->Default_Money_Thousands_Separator->CurrentValue;
		$this->Default_Money_Thousands_Separator->PlaceHolder = ew_RemoveHtml($this->Default_Money_Thousands_Separator->FldCaption());

		// Default_Money_Decimal_Point
		$this->Default_Money_Decimal_Point->EditAttrs["class"] = "form-control";
		$this->Default_Money_Decimal_Point->EditCustomAttributes = "";
		$this->Default_Money_Decimal_Point->EditValue = $this->Default_Money_Decimal_Point->CurrentValue;
		$this->Default_Money_Decimal_Point->PlaceHolder = ew_RemoveHtml($this->Default_Money_Decimal_Point->FldCaption());

		// Maintenance_Mode
		$this->Maintenance_Mode->EditCustomAttributes = "";
		$this->Maintenance_Mode->EditValue = $this->Maintenance_Mode->Options(FALSE);

		// Maintenance_Finish_DateTime
		$this->Maintenance_Finish_DateTime->EditAttrs["class"] = "form-control";
		$this->Maintenance_Finish_DateTime->EditCustomAttributes = "";
		$this->Maintenance_Finish_DateTime->EditValue = ew_FormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, 9);
		$this->Maintenance_Finish_DateTime->PlaceHolder = ew_RemoveHtml($this->Maintenance_Finish_DateTime->FldCaption());

		// Auto_Normal_After_Maintenance
		$this->Auto_Normal_After_Maintenance->EditCustomAttributes = "";
		$this->Auto_Normal_After_Maintenance->EditValue = $this->Auto_Normal_After_Maintenance->Options(FALSE);

		// Allow_User_To_Register
		$this->Allow_User_To_Register->EditCustomAttributes = "";
		$this->Allow_User_To_Register->EditValue = $this->Allow_User_To_Register->Options(FALSE);

		// Suspend_New_User_Account
		$this->Suspend_New_User_Account->EditCustomAttributes = "";
		$this->Suspend_New_User_Account->EditValue = $this->Suspend_New_User_Account->Options(FALSE);

		// User_Need_Activation_After_Registered
		$this->User_Need_Activation_After_Registered->EditCustomAttributes = "";
		$this->User_Need_Activation_After_Registered->EditValue = $this->User_Need_Activation_After_Registered->Options(FALSE);

		// Show_Captcha_On_Registration_Page
		$this->Show_Captcha_On_Registration_Page->EditCustomAttributes = "";
		$this->Show_Captcha_On_Registration_Page->EditValue = $this->Show_Captcha_On_Registration_Page->Options(FALSE);

		// Show_Terms_And_Conditions_On_Registration_Page
		$this->Show_Terms_And_Conditions_On_Registration_Page->EditCustomAttributes = "";
		$this->Show_Terms_And_Conditions_On_Registration_Page->EditValue = $this->Show_Terms_And_Conditions_On_Registration_Page->Options(FALSE);

		// User_Auto_Login_After_Activation_Or_Registration
		$this->User_Auto_Login_After_Activation_Or_Registration->EditCustomAttributes = "";
		$this->User_Auto_Login_After_Activation_Or_Registration->EditValue = $this->User_Auto_Login_After_Activation_Or_Registration->Options(FALSE);

		// Show_Captcha_On_Login_Page
		$this->Show_Captcha_On_Login_Page->EditCustomAttributes = "";
		$this->Show_Captcha_On_Login_Page->EditValue = $this->Show_Captcha_On_Login_Page->Options(FALSE);

		// Show_Captcha_On_Forgot_Password_Page
		$this->Show_Captcha_On_Forgot_Password_Page->EditCustomAttributes = "";
		$this->Show_Captcha_On_Forgot_Password_Page->EditValue = $this->Show_Captcha_On_Forgot_Password_Page->Options(FALSE);

		// Show_Captcha_On_Change_Password_Page
		$this->Show_Captcha_On_Change_Password_Page->EditCustomAttributes = "";
		$this->Show_Captcha_On_Change_Password_Page->EditValue = $this->Show_Captcha_On_Change_Password_Page->Options(FALSE);

		// User_Auto_Logout_After_Idle_In_Minutes
		$this->User_Auto_Logout_After_Idle_In_Minutes->EditAttrs["class"] = "form-control";
		$this->User_Auto_Logout_After_Idle_In_Minutes->EditCustomAttributes = "";
		$this->User_Auto_Logout_After_Idle_In_Minutes->EditValue = $this->User_Auto_Logout_After_Idle_In_Minutes->CurrentValue;
		$this->User_Auto_Logout_After_Idle_In_Minutes->PlaceHolder = ew_RemoveHtml($this->User_Auto_Logout_After_Idle_In_Minutes->FldCaption());

		// User_Login_Maximum_Retry
		$this->User_Login_Maximum_Retry->EditAttrs["class"] = "form-control";
		$this->User_Login_Maximum_Retry->EditCustomAttributes = "";
		$this->User_Login_Maximum_Retry->EditValue = $this->User_Login_Maximum_Retry->CurrentValue;
		$this->User_Login_Maximum_Retry->PlaceHolder = ew_RemoveHtml($this->User_Login_Maximum_Retry->FldCaption());

		// User_Login_Retry_Lockout
		$this->User_Login_Retry_Lockout->EditAttrs["class"] = "form-control";
		$this->User_Login_Retry_Lockout->EditCustomAttributes = "";
		$this->User_Login_Retry_Lockout->EditValue = $this->User_Login_Retry_Lockout->CurrentValue;
		$this->User_Login_Retry_Lockout->PlaceHolder = ew_RemoveHtml($this->User_Login_Retry_Lockout->FldCaption());

		// Redirect_To_Last_Visited_Page_After_Login
		$this->Redirect_To_Last_Visited_Page_After_Login->EditCustomAttributes = "";
		$this->Redirect_To_Last_Visited_Page_After_Login->EditValue = $this->Redirect_To_Last_Visited_Page_After_Login->Options(FALSE);

		// Enable_Password_Expiry
		$this->Enable_Password_Expiry->EditCustomAttributes = "";
		$this->Enable_Password_Expiry->EditValue = $this->Enable_Password_Expiry->Options(FALSE);

		// Password_Expiry_In_Days
		$this->Password_Expiry_In_Days->EditAttrs["class"] = "form-control";
		$this->Password_Expiry_In_Days->EditCustomAttributes = "";
		$this->Password_Expiry_In_Days->EditValue = $this->Password_Expiry_In_Days->CurrentValue;
		$this->Password_Expiry_In_Days->PlaceHolder = ew_RemoveHtml($this->Password_Expiry_In_Days->FldCaption());

		// Show_Entire_Header
		$this->Show_Entire_Header->EditCustomAttributes = "";
		$this->Show_Entire_Header->EditValue = $this->Show_Entire_Header->Options(FALSE);

		// Logo_Width
		$this->Logo_Width->EditAttrs["class"] = "form-control";
		$this->Logo_Width->EditCustomAttributes = "";
		$this->Logo_Width->EditValue = $this->Logo_Width->CurrentValue;
		$this->Logo_Width->PlaceHolder = ew_RemoveHtml($this->Logo_Width->FldCaption());

		// Show_Site_Title_In_Header
		$this->Show_Site_Title_In_Header->EditCustomAttributes = "";
		$this->Show_Site_Title_In_Header->EditValue = $this->Show_Site_Title_In_Header->Options(FALSE);

		// Show_Current_User_In_Header
		$this->Show_Current_User_In_Header->EditCustomAttributes = "";
		$this->Show_Current_User_In_Header->EditValue = $this->Show_Current_User_In_Header->Options(FALSE);

		// Text_Align_In_Header
		$this->Text_Align_In_Header->EditCustomAttributes = "";
		$this->Text_Align_In_Header->EditValue = $this->Text_Align_In_Header->Options(FALSE);

		// Site_Title_Text_Style
		$this->Site_Title_Text_Style->EditCustomAttributes = "";
		$this->Site_Title_Text_Style->EditValue = $this->Site_Title_Text_Style->Options(FALSE);

		// Language_Selector_Visibility
		$this->Language_Selector_Visibility->EditCustomAttributes = "";
		$this->Language_Selector_Visibility->EditValue = $this->Language_Selector_Visibility->Options(FALSE);

		// Language_Selector_Align
		$this->Language_Selector_Align->EditCustomAttributes = "";
		$this->Language_Selector_Align->EditValue = $this->Language_Selector_Align->Options(FALSE);

		// Show_Entire_Footer
		$this->Show_Entire_Footer->EditCustomAttributes = "";
		$this->Show_Entire_Footer->EditValue = $this->Show_Entire_Footer->Options(FALSE);

		// Show_Text_In_Footer
		$this->Show_Text_In_Footer->EditCustomAttributes = "";
		$this->Show_Text_In_Footer->EditValue = $this->Show_Text_In_Footer->Options(FALSE);

		// Show_Back_To_Top_On_Footer
		$this->Show_Back_To_Top_On_Footer->EditCustomAttributes = "";
		$this->Show_Back_To_Top_On_Footer->EditValue = $this->Show_Back_To_Top_On_Footer->Options(FALSE);

		// Show_Terms_And_Conditions_On_Footer
		$this->Show_Terms_And_Conditions_On_Footer->EditCustomAttributes = "";
		$this->Show_Terms_And_Conditions_On_Footer->EditValue = $this->Show_Terms_And_Conditions_On_Footer->Options(FALSE);

		// Show_About_Us_On_Footer
		$this->Show_About_Us_On_Footer->EditCustomAttributes = "";
		$this->Show_About_Us_On_Footer->EditValue = $this->Show_About_Us_On_Footer->Options(FALSE);

		// Pagination_Position
		$this->Pagination_Position->EditCustomAttributes = "";
		$this->Pagination_Position->EditValue = $this->Pagination_Position->Options(FALSE);

		// Pagination_Style
		$this->Pagination_Style->EditCustomAttributes = "";
		$this->Pagination_Style->EditValue = $this->Pagination_Style->Options(FALSE);

		// Selectable_Records_Per_Page
		$this->Selectable_Records_Per_Page->EditAttrs["class"] = "form-control";
		$this->Selectable_Records_Per_Page->EditCustomAttributes = "";
		$this->Selectable_Records_Per_Page->EditValue = $this->Selectable_Records_Per_Page->CurrentValue;
		$this->Selectable_Records_Per_Page->PlaceHolder = ew_RemoveHtml($this->Selectable_Records_Per_Page->FldCaption());

		// Selectable_Groups_Per_Page
		$this->Selectable_Groups_Per_Page->EditAttrs["class"] = "form-control";
		$this->Selectable_Groups_Per_Page->EditCustomAttributes = "";
		$this->Selectable_Groups_Per_Page->EditValue = $this->Selectable_Groups_Per_Page->CurrentValue;
		$this->Selectable_Groups_Per_Page->PlaceHolder = ew_RemoveHtml($this->Selectable_Groups_Per_Page->FldCaption());

		// Default_Record_Per_Page
		$this->Default_Record_Per_Page->EditAttrs["class"] = "form-control";
		$this->Default_Record_Per_Page->EditCustomAttributes = "";
		$this->Default_Record_Per_Page->EditValue = $this->Default_Record_Per_Page->CurrentValue;
		$this->Default_Record_Per_Page->PlaceHolder = ew_RemoveHtml($this->Default_Record_Per_Page->FldCaption());

		// Default_Group_Per_Page
		$this->Default_Group_Per_Page->EditAttrs["class"] = "form-control";
		$this->Default_Group_Per_Page->EditCustomAttributes = "";
		$this->Default_Group_Per_Page->EditValue = $this->Default_Group_Per_Page->CurrentValue;
		$this->Default_Group_Per_Page->PlaceHolder = ew_RemoveHtml($this->Default_Group_Per_Page->FldCaption());

		// Maximum_Selected_Records
		$this->Maximum_Selected_Records->EditAttrs["class"] = "form-control";
		$this->Maximum_Selected_Records->EditCustomAttributes = "";
		$this->Maximum_Selected_Records->EditValue = $this->Maximum_Selected_Records->CurrentValue;
		$this->Maximum_Selected_Records->PlaceHolder = ew_RemoveHtml($this->Maximum_Selected_Records->FldCaption());

		// Maximum_Selected_Groups
		$this->Maximum_Selected_Groups->EditAttrs["class"] = "form-control";
		$this->Maximum_Selected_Groups->EditCustomAttributes = "";
		$this->Maximum_Selected_Groups->EditValue = $this->Maximum_Selected_Groups->CurrentValue;
		$this->Maximum_Selected_Groups->PlaceHolder = ew_RemoveHtml($this->Maximum_Selected_Groups->FldCaption());

		// Show_PageNum_If_Record_Not_Over_Pagesize
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->EditCustomAttributes = "";
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->EditValue = $this->Show_PageNum_If_Record_Not_Over_Pagesize->Options(FALSE);

		// Table_Width_Style
		$this->Table_Width_Style->EditCustomAttributes = "";
		$this->Table_Width_Style->EditValue = $this->Table_Width_Style->Options(FALSE);

		// Scroll_Table_Width
		$this->Scroll_Table_Width->EditAttrs["class"] = "form-control";
		$this->Scroll_Table_Width->EditCustomAttributes = "";
		$this->Scroll_Table_Width->EditValue = $this->Scroll_Table_Width->CurrentValue;
		$this->Scroll_Table_Width->PlaceHolder = ew_RemoveHtml($this->Scroll_Table_Width->FldCaption());

		// Scroll_Table_Height
		$this->Scroll_Table_Height->EditAttrs["class"] = "form-control";
		$this->Scroll_Table_Height->EditCustomAttributes = "";
		$this->Scroll_Table_Height->EditValue = $this->Scroll_Table_Height->CurrentValue;
		$this->Scroll_Table_Height->PlaceHolder = ew_RemoveHtml($this->Scroll_Table_Height->FldCaption());

		// Search_Panel_Collapsed
		$this->Search_Panel_Collapsed->EditCustomAttributes = "";
		$this->Search_Panel_Collapsed->EditValue = $this->Search_Panel_Collapsed->Options(FALSE);

		// Filter_Panel_Collapsed
		$this->Filter_Panel_Collapsed->EditCustomAttributes = "";
		$this->Filter_Panel_Collapsed->EditValue = $this->Filter_Panel_Collapsed->Options(FALSE);

		// Show_Record_Number_On_List_Page
		$this->Show_Record_Number_On_List_Page->EditCustomAttributes = "";
		$this->Show_Record_Number_On_List_Page->EditValue = $this->Show_Record_Number_On_List_Page->Options(FALSE);

		// Show_Empty_Table_On_List_Page
		$this->Show_Empty_Table_On_List_Page->EditCustomAttributes = "";
		$this->Show_Empty_Table_On_List_Page->EditValue = $this->Show_Empty_Table_On_List_Page->Options(FALSE);

		// Rows_Vertical_Align_Top
		$this->Rows_Vertical_Align_Top->EditCustomAttributes = "";
		$this->Rows_Vertical_Align_Top->EditValue = $this->Rows_Vertical_Align_Top->Options(FALSE);

		// Action_Button_Alignment
		$this->Action_Button_Alignment->EditCustomAttributes = "";
		$this->Action_Button_Alignment->EditValue = $this->Action_Button_Alignment->Options(FALSE);

		// Show_Add_Success_Message
		$this->Show_Add_Success_Message->EditCustomAttributes = "";
		$this->Show_Add_Success_Message->EditValue = $this->Show_Add_Success_Message->Options(FALSE);

		// Show_Edit_Success_Message
		$this->Show_Edit_Success_Message->EditCustomAttributes = "";
		$this->Show_Edit_Success_Message->EditValue = $this->Show_Edit_Success_Message->Options(FALSE);

		// jQuery_Auto_Hide_Success_Message
		$this->jQuery_Auto_Hide_Success_Message->EditCustomAttributes = "";
		$this->jQuery_Auto_Hide_Success_Message->EditValue = $this->jQuery_Auto_Hide_Success_Message->Options(FALSE);

		// Use_Javascript_Message
		$this->Use_Javascript_Message->EditCustomAttributes = "";
		$this->Use_Javascript_Message->EditValue = $this->Use_Javascript_Message->Options(FALSE);

		// Login_Window_Type
		$this->Login_Window_Type->EditCustomAttributes = "";
		$this->Login_Window_Type->EditValue = $this->Login_Window_Type->Options(FALSE);

		// Forgot_Password_Window_Type
		$this->Forgot_Password_Window_Type->EditCustomAttributes = "";
		$this->Forgot_Password_Window_Type->EditValue = $this->Forgot_Password_Window_Type->Options(FALSE);

		// Change_Password_Window_Type
		$this->Change_Password_Window_Type->EditCustomAttributes = "";
		$this->Change_Password_Window_Type->EditValue = $this->Change_Password_Window_Type->Options(FALSE);

		// Registration_Window_Type
		$this->Registration_Window_Type->EditCustomAttributes = "";
		$this->Registration_Window_Type->EditValue = $this->Registration_Window_Type->Options(FALSE);

		// Show_Record_Number_On_Detail_Preview
		$this->Show_Record_Number_On_Detail_Preview->EditCustomAttributes = "";
		$this->Show_Record_Number_On_Detail_Preview->EditValue = $this->Show_Record_Number_On_Detail_Preview->Options(FALSE);

		// Show_Empty_Table_In_Detail_Preview
		$this->Show_Empty_Table_In_Detail_Preview->EditCustomAttributes = "";
		$this->Show_Empty_Table_In_Detail_Preview->EditValue = $this->Show_Empty_Table_In_Detail_Preview->Options(FALSE);

		// Detail_Preview_Table_Width
		$this->Detail_Preview_Table_Width->EditAttrs["class"] = "form-control";
		$this->Detail_Preview_Table_Width->EditCustomAttributes = "";
		$this->Detail_Preview_Table_Width->EditValue = $this->Detail_Preview_Table_Width->CurrentValue;
		$this->Detail_Preview_Table_Width->PlaceHolder = ew_RemoveHtml($this->Detail_Preview_Table_Width->FldCaption());

		// Password_Minimum_Length
		$this->Password_Minimum_Length->EditAttrs["class"] = "form-control";
		$this->Password_Minimum_Length->EditCustomAttributes = "";
		$this->Password_Minimum_Length->EditValue = $this->Password_Minimum_Length->CurrentValue;
		$this->Password_Minimum_Length->PlaceHolder = ew_RemoveHtml($this->Password_Minimum_Length->FldCaption());

		// Password_Maximum_Length
		$this->Password_Maximum_Length->EditAttrs["class"] = "form-control";
		$this->Password_Maximum_Length->EditCustomAttributes = "";
		$this->Password_Maximum_Length->EditValue = $this->Password_Maximum_Length->CurrentValue;
		$this->Password_Maximum_Length->PlaceHolder = ew_RemoveHtml($this->Password_Maximum_Length->FldCaption());

		// Password_Must_Contain_At_Least_One_Lower_Case
		$this->Password_Must_Contain_At_Least_One_Lower_Case->EditCustomAttributes = "";
		$this->Password_Must_Contain_At_Least_One_Lower_Case->EditValue = $this->Password_Must_Contain_At_Least_One_Lower_Case->Options(FALSE);

		// Password_Must_Comply_With_Minumum_Length
		$this->Password_Must_Comply_With_Minumum_Length->EditCustomAttributes = "";
		$this->Password_Must_Comply_With_Minumum_Length->EditValue = $this->Password_Must_Comply_With_Minumum_Length->Options(FALSE);

		// Password_Must_Comply_With_Maximum_Length
		$this->Password_Must_Comply_With_Maximum_Length->EditCustomAttributes = "";
		$this->Password_Must_Comply_With_Maximum_Length->EditValue = $this->Password_Must_Comply_With_Maximum_Length->Options(FALSE);

		// Password_Must_Contain_At_Least_One_Upper_Case
		$this->Password_Must_Contain_At_Least_One_Upper_Case->EditCustomAttributes = "";
		$this->Password_Must_Contain_At_Least_One_Upper_Case->EditValue = $this->Password_Must_Contain_At_Least_One_Upper_Case->Options(FALSE);

		// Password_Must_Contain_At_Least_One_Numeric
		$this->Password_Must_Contain_At_Least_One_Numeric->EditCustomAttributes = "";
		$this->Password_Must_Contain_At_Least_One_Numeric->EditValue = $this->Password_Must_Contain_At_Least_One_Numeric->Options(FALSE);

		// Password_Must_Contain_At_Least_One_Symbol
		$this->Password_Must_Contain_At_Least_One_Symbol->EditCustomAttributes = "";
		$this->Password_Must_Contain_At_Least_One_Symbol->EditValue = $this->Password_Must_Contain_At_Least_One_Symbol->Options(FALSE);

		// Password_Must_Be_Difference_Between_Old_And_New
		$this->Password_Must_Be_Difference_Between_Old_And_New->EditCustomAttributes = "";
		$this->Password_Must_Be_Difference_Between_Old_And_New->EditValue = $this->Password_Must_Be_Difference_Between_Old_And_New->Options(FALSE);

		// Reset_Password_Field_Options
		$this->Reset_Password_Field_Options->EditCustomAttributes = "";
		$this->Reset_Password_Field_Options->EditValue = $this->Reset_Password_Field_Options->Options(FALSE);

		// Export_Record_Options
		$this->Export_Record_Options->EditCustomAttributes = "";
		$this->Export_Record_Options->EditValue = $this->Export_Record_Options->Options(FALSE);

		// Show_Record_Number_On_Exported_List_Page
		$this->Show_Record_Number_On_Exported_List_Page->EditCustomAttributes = "";
		$this->Show_Record_Number_On_Exported_List_Page->EditValue = $this->Show_Record_Number_On_Exported_List_Page->Options(FALSE);

		// Use_Table_Setting_For_Export_Field_Caption
		$this->Use_Table_Setting_For_Export_Field_Caption->EditCustomAttributes = "";
		$this->Use_Table_Setting_For_Export_Field_Caption->EditValue = $this->Use_Table_Setting_For_Export_Field_Caption->Options(FALSE);

		// Use_Table_Setting_For_Export_Original_Value
		$this->Use_Table_Setting_For_Export_Original_Value->EditCustomAttributes = "";
		$this->Use_Table_Setting_For_Export_Original_Value->EditValue = $this->Use_Table_Setting_For_Export_Original_Value->Options(FALSE);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		global $Language, $gsLanguage;
		if (MS_USE_TABLE_SETTING_FOR_EXPORT_FIELD_CAPTION) {
			define("EW_EXPORT_FIELD_CAPTION", FALSE, FALSE);
		}
		if (MS_USE_TABLE_SETTING_FOR_EXPORT_ORIGINAL_VALUE) {
			define("EW_EXPORT_ORIGINAL_VALUE", FALSE, FALSE);
		}
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->Option_ID->Exportable) $Doc->ExportCaption($this->Option_ID);
					if ($this->Option_Default->Exportable) $Doc->ExportCaption($this->Option_Default);
					if ($this->Default_Theme->Exportable) $Doc->ExportCaption($this->Default_Theme);
					if ($this->Font_Name->Exportable) $Doc->ExportCaption($this->Font_Name);
					if ($this->Font_Size->Exportable) $Doc->ExportCaption($this->Font_Size);
					if ($this->Show_Border_Layout->Exportable) $Doc->ExportCaption($this->Show_Border_Layout);
					if ($this->Show_Shadow_Layout->Exportable) $Doc->ExportCaption($this->Show_Shadow_Layout);
					if ($this->Menu_Horizontal->Exportable) $Doc->ExportCaption($this->Menu_Horizontal);
					if ($this->Vertical_Menu_Width->Exportable) $Doc->ExportCaption($this->Vertical_Menu_Width);
					if ($this->Show_Announcement->Exportable) $Doc->ExportCaption($this->Show_Announcement);
					if ($this->Demo_Mode->Exportable) $Doc->ExportCaption($this->Demo_Mode);
					if ($this->Show_Page_Processing_Time->Exportable) $Doc->ExportCaption($this->Show_Page_Processing_Time);
					if ($this->Allow_User_Preferences->Exportable) $Doc->ExportCaption($this->Allow_User_Preferences);
					if ($this->SMTP_Server->Exportable) $Doc->ExportCaption($this->SMTP_Server);
					if ($this->SMTP_Server_Port->Exportable) $Doc->ExportCaption($this->SMTP_Server_Port);
					if ($this->SMTP_Server_Username->Exportable) $Doc->ExportCaption($this->SMTP_Server_Username);
					if ($this->SMTP_Server_Password->Exportable) $Doc->ExportCaption($this->SMTP_Server_Password);
					if ($this->Sender_Email->Exportable) $Doc->ExportCaption($this->Sender_Email);
					if ($this->Recipient_Email->Exportable) $Doc->ExportCaption($this->Recipient_Email);
					if ($this->Use_Default_Locale->Exportable) $Doc->ExportCaption($this->Use_Default_Locale);
					if ($this->Default_Language->Exportable) $Doc->ExportCaption($this->Default_Language);
					if ($this->Default_Timezone->Exportable) $Doc->ExportCaption($this->Default_Timezone);
					if ($this->Default_Thousands_Separator->Exportable) $Doc->ExportCaption($this->Default_Thousands_Separator);
					if ($this->Default_Decimal_Point->Exportable) $Doc->ExportCaption($this->Default_Decimal_Point);
					if ($this->Default_Currency_Symbol->Exportable) $Doc->ExportCaption($this->Default_Currency_Symbol);
					if ($this->Default_Money_Thousands_Separator->Exportable) $Doc->ExportCaption($this->Default_Money_Thousands_Separator);
					if ($this->Default_Money_Decimal_Point->Exportable) $Doc->ExportCaption($this->Default_Money_Decimal_Point);
					if ($this->Maintenance_Mode->Exportable) $Doc->ExportCaption($this->Maintenance_Mode);
					if ($this->Maintenance_Finish_DateTime->Exportable) $Doc->ExportCaption($this->Maintenance_Finish_DateTime);
					if ($this->Auto_Normal_After_Maintenance->Exportable) $Doc->ExportCaption($this->Auto_Normal_After_Maintenance);
					if ($this->Allow_User_To_Register->Exportable) $Doc->ExportCaption($this->Allow_User_To_Register);
					if ($this->Suspend_New_User_Account->Exportable) $Doc->ExportCaption($this->Suspend_New_User_Account);
					if ($this->User_Need_Activation_After_Registered->Exportable) $Doc->ExportCaption($this->User_Need_Activation_After_Registered);
					if ($this->Show_Captcha_On_Registration_Page->Exportable) $Doc->ExportCaption($this->Show_Captcha_On_Registration_Page);
					if ($this->Show_Terms_And_Conditions_On_Registration_Page->Exportable) $Doc->ExportCaption($this->Show_Terms_And_Conditions_On_Registration_Page);
					if ($this->User_Auto_Login_After_Activation_Or_Registration->Exportable) $Doc->ExportCaption($this->User_Auto_Login_After_Activation_Or_Registration);
					if ($this->Show_Captcha_On_Login_Page->Exportable) $Doc->ExportCaption($this->Show_Captcha_On_Login_Page);
					if ($this->Show_Captcha_On_Forgot_Password_Page->Exportable) $Doc->ExportCaption($this->Show_Captcha_On_Forgot_Password_Page);
					if ($this->Show_Captcha_On_Change_Password_Page->Exportable) $Doc->ExportCaption($this->Show_Captcha_On_Change_Password_Page);
					if ($this->User_Auto_Logout_After_Idle_In_Minutes->Exportable) $Doc->ExportCaption($this->User_Auto_Logout_After_Idle_In_Minutes);
					if ($this->User_Login_Maximum_Retry->Exportable) $Doc->ExportCaption($this->User_Login_Maximum_Retry);
					if ($this->User_Login_Retry_Lockout->Exportable) $Doc->ExportCaption($this->User_Login_Retry_Lockout);
					if ($this->Redirect_To_Last_Visited_Page_After_Login->Exportable) $Doc->ExportCaption($this->Redirect_To_Last_Visited_Page_After_Login);
					if ($this->Enable_Password_Expiry->Exportable) $Doc->ExportCaption($this->Enable_Password_Expiry);
					if ($this->Password_Expiry_In_Days->Exportable) $Doc->ExportCaption($this->Password_Expiry_In_Days);
					if ($this->Show_Entire_Header->Exportable) $Doc->ExportCaption($this->Show_Entire_Header);
					if ($this->Logo_Width->Exportable) $Doc->ExportCaption($this->Logo_Width);
					if ($this->Show_Site_Title_In_Header->Exportable) $Doc->ExportCaption($this->Show_Site_Title_In_Header);
					if ($this->Show_Current_User_In_Header->Exportable) $Doc->ExportCaption($this->Show_Current_User_In_Header);
					if ($this->Text_Align_In_Header->Exportable) $Doc->ExportCaption($this->Text_Align_In_Header);
					if ($this->Site_Title_Text_Style->Exportable) $Doc->ExportCaption($this->Site_Title_Text_Style);
					if ($this->Language_Selector_Visibility->Exportable) $Doc->ExportCaption($this->Language_Selector_Visibility);
					if ($this->Language_Selector_Align->Exportable) $Doc->ExportCaption($this->Language_Selector_Align);
					if ($this->Show_Entire_Footer->Exportable) $Doc->ExportCaption($this->Show_Entire_Footer);
					if ($this->Show_Text_In_Footer->Exportable) $Doc->ExportCaption($this->Show_Text_In_Footer);
					if ($this->Show_Back_To_Top_On_Footer->Exportable) $Doc->ExportCaption($this->Show_Back_To_Top_On_Footer);
					if ($this->Show_Terms_And_Conditions_On_Footer->Exportable) $Doc->ExportCaption($this->Show_Terms_And_Conditions_On_Footer);
					if ($this->Show_About_Us_On_Footer->Exportable) $Doc->ExportCaption($this->Show_About_Us_On_Footer);
					if ($this->Pagination_Position->Exportable) $Doc->ExportCaption($this->Pagination_Position);
					if ($this->Pagination_Style->Exportable) $Doc->ExportCaption($this->Pagination_Style);
					if ($this->Selectable_Records_Per_Page->Exportable) $Doc->ExportCaption($this->Selectable_Records_Per_Page);
					if ($this->Selectable_Groups_Per_Page->Exportable) $Doc->ExportCaption($this->Selectable_Groups_Per_Page);
					if ($this->Default_Record_Per_Page->Exportable) $Doc->ExportCaption($this->Default_Record_Per_Page);
					if ($this->Default_Group_Per_Page->Exportable) $Doc->ExportCaption($this->Default_Group_Per_Page);
					if ($this->Maximum_Selected_Records->Exportable) $Doc->ExportCaption($this->Maximum_Selected_Records);
					if ($this->Maximum_Selected_Groups->Exportable) $Doc->ExportCaption($this->Maximum_Selected_Groups);
					if ($this->Show_PageNum_If_Record_Not_Over_Pagesize->Exportable) $Doc->ExportCaption($this->Show_PageNum_If_Record_Not_Over_Pagesize);
					if ($this->Table_Width_Style->Exportable) $Doc->ExportCaption($this->Table_Width_Style);
					if ($this->Scroll_Table_Width->Exportable) $Doc->ExportCaption($this->Scroll_Table_Width);
					if ($this->Scroll_Table_Height->Exportable) $Doc->ExportCaption($this->Scroll_Table_Height);
					if ($this->Search_Panel_Collapsed->Exportable) $Doc->ExportCaption($this->Search_Panel_Collapsed);
					if ($this->Filter_Panel_Collapsed->Exportable) $Doc->ExportCaption($this->Filter_Panel_Collapsed);
					if ($this->Show_Record_Number_On_List_Page->Exportable) $Doc->ExportCaption($this->Show_Record_Number_On_List_Page);
					if ($this->Show_Empty_Table_On_List_Page->Exportable) $Doc->ExportCaption($this->Show_Empty_Table_On_List_Page);
					if ($this->Rows_Vertical_Align_Top->Exportable) $Doc->ExportCaption($this->Rows_Vertical_Align_Top);
					if ($this->Action_Button_Alignment->Exportable) $Doc->ExportCaption($this->Action_Button_Alignment);
					if ($this->Show_Add_Success_Message->Exportable) $Doc->ExportCaption($this->Show_Add_Success_Message);
					if ($this->Show_Edit_Success_Message->Exportable) $Doc->ExportCaption($this->Show_Edit_Success_Message);
					if ($this->jQuery_Auto_Hide_Success_Message->Exportable) $Doc->ExportCaption($this->jQuery_Auto_Hide_Success_Message);
					if ($this->Use_Javascript_Message->Exportable) $Doc->ExportCaption($this->Use_Javascript_Message);
					if ($this->Login_Window_Type->Exportable) $Doc->ExportCaption($this->Login_Window_Type);
					if ($this->Forgot_Password_Window_Type->Exportable) $Doc->ExportCaption($this->Forgot_Password_Window_Type);
					if ($this->Change_Password_Window_Type->Exportable) $Doc->ExportCaption($this->Change_Password_Window_Type);
					if ($this->Registration_Window_Type->Exportable) $Doc->ExportCaption($this->Registration_Window_Type);
					if ($this->Show_Record_Number_On_Detail_Preview->Exportable) $Doc->ExportCaption($this->Show_Record_Number_On_Detail_Preview);
					if ($this->Show_Empty_Table_In_Detail_Preview->Exportable) $Doc->ExportCaption($this->Show_Empty_Table_In_Detail_Preview);
					if ($this->Detail_Preview_Table_Width->Exportable) $Doc->ExportCaption($this->Detail_Preview_Table_Width);
					if ($this->Password_Minimum_Length->Exportable) $Doc->ExportCaption($this->Password_Minimum_Length);
					if ($this->Password_Maximum_Length->Exportable) $Doc->ExportCaption($this->Password_Maximum_Length);
					if ($this->Password_Must_Contain_At_Least_One_Lower_Case->Exportable) $Doc->ExportCaption($this->Password_Must_Contain_At_Least_One_Lower_Case);
					if ($this->Password_Must_Comply_With_Minumum_Length->Exportable) $Doc->ExportCaption($this->Password_Must_Comply_With_Minumum_Length);
					if ($this->Password_Must_Comply_With_Maximum_Length->Exportable) $Doc->ExportCaption($this->Password_Must_Comply_With_Maximum_Length);
					if ($this->Password_Must_Contain_At_Least_One_Upper_Case->Exportable) $Doc->ExportCaption($this->Password_Must_Contain_At_Least_One_Upper_Case);
					if ($this->Password_Must_Contain_At_Least_One_Numeric->Exportable) $Doc->ExportCaption($this->Password_Must_Contain_At_Least_One_Numeric);
					if ($this->Password_Must_Contain_At_Least_One_Symbol->Exportable) $Doc->ExportCaption($this->Password_Must_Contain_At_Least_One_Symbol);
					if ($this->Password_Must_Be_Difference_Between_Old_And_New->Exportable) $Doc->ExportCaption($this->Password_Must_Be_Difference_Between_Old_And_New);
					if ($this->Reset_Password_Field_Options->Exportable) $Doc->ExportCaption($this->Reset_Password_Field_Options);
					if ($this->Export_Record_Options->Exportable) $Doc->ExportCaption($this->Export_Record_Options);
					if ($this->Show_Record_Number_On_Exported_List_Page->Exportable) $Doc->ExportCaption($this->Show_Record_Number_On_Exported_List_Page);
					if ($this->Use_Table_Setting_For_Export_Field_Caption->Exportable) $Doc->ExportCaption($this->Use_Table_Setting_For_Export_Field_Caption);
					if ($this->Use_Table_Setting_For_Export_Original_Value->Exportable) $Doc->ExportCaption($this->Use_Table_Setting_For_Export_Original_Value);
				} else {

				// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
					if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) { 
						if (MS_RECORD_NUMBER_LONG_CAPTION_COLUMN_TABLE) {
							$Doc->ExportText($Language->Phrase('LongRecNo'));
						} else {
							$Doc->ExportText($Language->Phrase('ShortRecNo'));
						}
					}

				// End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
					if ($this->Option_ID->Exportable) $Doc->ExportCaption($this->Option_ID);
					if ($this->Option_Default->Exportable) $Doc->ExportCaption($this->Option_Default);
					if ($this->Default_Theme->Exportable) $Doc->ExportCaption($this->Default_Theme);
					if ($this->Show_Border_Layout->Exportable) $Doc->ExportCaption($this->Show_Border_Layout);
					if ($this->Show_Shadow_Layout->Exportable) $Doc->ExportCaption($this->Show_Shadow_Layout);
					if ($this->Menu_Horizontal->Exportable) $Doc->ExportCaption($this->Menu_Horizontal);
					if ($this->Show_Announcement->Exportable) $Doc->ExportCaption($this->Show_Announcement);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->Option_ID->Exportable) $Doc->ExportField($this->Option_ID);
						if ($this->Option_Default->Exportable) $Doc->ExportField($this->Option_Default);
						if ($this->Default_Theme->Exportable) $Doc->ExportField($this->Default_Theme);
						if ($this->Font_Name->Exportable) $Doc->ExportField($this->Font_Name);
						if ($this->Font_Size->Exportable) $Doc->ExportField($this->Font_Size);
						if ($this->Show_Border_Layout->Exportable) $Doc->ExportField($this->Show_Border_Layout);
						if ($this->Show_Shadow_Layout->Exportable) $Doc->ExportField($this->Show_Shadow_Layout);
						if ($this->Menu_Horizontal->Exportable) $Doc->ExportField($this->Menu_Horizontal);
						if ($this->Vertical_Menu_Width->Exportable) $Doc->ExportField($this->Vertical_Menu_Width);
						if ($this->Show_Announcement->Exportable) $Doc->ExportField($this->Show_Announcement);
						if ($this->Demo_Mode->Exportable) $Doc->ExportField($this->Demo_Mode);
						if ($this->Show_Page_Processing_Time->Exportable) $Doc->ExportField($this->Show_Page_Processing_Time);
						if ($this->Allow_User_Preferences->Exportable) $Doc->ExportField($this->Allow_User_Preferences);
						if ($this->SMTP_Server->Exportable) $Doc->ExportField($this->SMTP_Server);
						if ($this->SMTP_Server_Port->Exportable) $Doc->ExportField($this->SMTP_Server_Port);
						if ($this->SMTP_Server_Username->Exportable) $Doc->ExportField($this->SMTP_Server_Username);
						if ($this->SMTP_Server_Password->Exportable) $Doc->ExportField($this->SMTP_Server_Password);
						if ($this->Sender_Email->Exportable) $Doc->ExportField($this->Sender_Email);
						if ($this->Recipient_Email->Exportable) $Doc->ExportField($this->Recipient_Email);
						if ($this->Use_Default_Locale->Exportable) $Doc->ExportField($this->Use_Default_Locale);
						if ($this->Default_Language->Exportable) $Doc->ExportField($this->Default_Language);
						if ($this->Default_Timezone->Exportable) $Doc->ExportField($this->Default_Timezone);
						if ($this->Default_Thousands_Separator->Exportable) $Doc->ExportField($this->Default_Thousands_Separator);
						if ($this->Default_Decimal_Point->Exportable) $Doc->ExportField($this->Default_Decimal_Point);
						if ($this->Default_Currency_Symbol->Exportable) $Doc->ExportField($this->Default_Currency_Symbol);
						if ($this->Default_Money_Thousands_Separator->Exportable) $Doc->ExportField($this->Default_Money_Thousands_Separator);
						if ($this->Default_Money_Decimal_Point->Exportable) $Doc->ExportField($this->Default_Money_Decimal_Point);
						if ($this->Maintenance_Mode->Exportable) $Doc->ExportField($this->Maintenance_Mode);
						if ($this->Maintenance_Finish_DateTime->Exportable) $Doc->ExportField($this->Maintenance_Finish_DateTime);
						if ($this->Auto_Normal_After_Maintenance->Exportable) $Doc->ExportField($this->Auto_Normal_After_Maintenance);
						if ($this->Allow_User_To_Register->Exportable) $Doc->ExportField($this->Allow_User_To_Register);
						if ($this->Suspend_New_User_Account->Exportable) $Doc->ExportField($this->Suspend_New_User_Account);
						if ($this->User_Need_Activation_After_Registered->Exportable) $Doc->ExportField($this->User_Need_Activation_After_Registered);
						if ($this->Show_Captcha_On_Registration_Page->Exportable) $Doc->ExportField($this->Show_Captcha_On_Registration_Page);
						if ($this->Show_Terms_And_Conditions_On_Registration_Page->Exportable) $Doc->ExportField($this->Show_Terms_And_Conditions_On_Registration_Page);
						if ($this->User_Auto_Login_After_Activation_Or_Registration->Exportable) $Doc->ExportField($this->User_Auto_Login_After_Activation_Or_Registration);
						if ($this->Show_Captcha_On_Login_Page->Exportable) $Doc->ExportField($this->Show_Captcha_On_Login_Page);
						if ($this->Show_Captcha_On_Forgot_Password_Page->Exportable) $Doc->ExportField($this->Show_Captcha_On_Forgot_Password_Page);
						if ($this->Show_Captcha_On_Change_Password_Page->Exportable) $Doc->ExportField($this->Show_Captcha_On_Change_Password_Page);
						if ($this->User_Auto_Logout_After_Idle_In_Minutes->Exportable) $Doc->ExportField($this->User_Auto_Logout_After_Idle_In_Minutes);
						if ($this->User_Login_Maximum_Retry->Exportable) $Doc->ExportField($this->User_Login_Maximum_Retry);
						if ($this->User_Login_Retry_Lockout->Exportable) $Doc->ExportField($this->User_Login_Retry_Lockout);
						if ($this->Redirect_To_Last_Visited_Page_After_Login->Exportable) $Doc->ExportField($this->Redirect_To_Last_Visited_Page_After_Login);
						if ($this->Enable_Password_Expiry->Exportable) $Doc->ExportField($this->Enable_Password_Expiry);
						if ($this->Password_Expiry_In_Days->Exportable) $Doc->ExportField($this->Password_Expiry_In_Days);
						if ($this->Show_Entire_Header->Exportable) $Doc->ExportField($this->Show_Entire_Header);
						if ($this->Logo_Width->Exportable) $Doc->ExportField($this->Logo_Width);
						if ($this->Show_Site_Title_In_Header->Exportable) $Doc->ExportField($this->Show_Site_Title_In_Header);
						if ($this->Show_Current_User_In_Header->Exportable) $Doc->ExportField($this->Show_Current_User_In_Header);
						if ($this->Text_Align_In_Header->Exportable) $Doc->ExportField($this->Text_Align_In_Header);
						if ($this->Site_Title_Text_Style->Exportable) $Doc->ExportField($this->Site_Title_Text_Style);
						if ($this->Language_Selector_Visibility->Exportable) $Doc->ExportField($this->Language_Selector_Visibility);
						if ($this->Language_Selector_Align->Exportable) $Doc->ExportField($this->Language_Selector_Align);
						if ($this->Show_Entire_Footer->Exportable) $Doc->ExportField($this->Show_Entire_Footer);
						if ($this->Show_Text_In_Footer->Exportable) $Doc->ExportField($this->Show_Text_In_Footer);
						if ($this->Show_Back_To_Top_On_Footer->Exportable) $Doc->ExportField($this->Show_Back_To_Top_On_Footer);
						if ($this->Show_Terms_And_Conditions_On_Footer->Exportable) $Doc->ExportField($this->Show_Terms_And_Conditions_On_Footer);
						if ($this->Show_About_Us_On_Footer->Exportable) $Doc->ExportField($this->Show_About_Us_On_Footer);
						if ($this->Pagination_Position->Exportable) $Doc->ExportField($this->Pagination_Position);
						if ($this->Pagination_Style->Exportable) $Doc->ExportField($this->Pagination_Style);
						if ($this->Selectable_Records_Per_Page->Exportable) $Doc->ExportField($this->Selectable_Records_Per_Page);
						if ($this->Selectable_Groups_Per_Page->Exportable) $Doc->ExportField($this->Selectable_Groups_Per_Page);
						if ($this->Default_Record_Per_Page->Exportable) $Doc->ExportField($this->Default_Record_Per_Page);
						if ($this->Default_Group_Per_Page->Exportable) $Doc->ExportField($this->Default_Group_Per_Page);
						if ($this->Maximum_Selected_Records->Exportable) $Doc->ExportField($this->Maximum_Selected_Records);
						if ($this->Maximum_Selected_Groups->Exportable) $Doc->ExportField($this->Maximum_Selected_Groups);
						if ($this->Show_PageNum_If_Record_Not_Over_Pagesize->Exportable) $Doc->ExportField($this->Show_PageNum_If_Record_Not_Over_Pagesize);
						if ($this->Table_Width_Style->Exportable) $Doc->ExportField($this->Table_Width_Style);
						if ($this->Scroll_Table_Width->Exportable) $Doc->ExportField($this->Scroll_Table_Width);
						if ($this->Scroll_Table_Height->Exportable) $Doc->ExportField($this->Scroll_Table_Height);
						if ($this->Search_Panel_Collapsed->Exportable) $Doc->ExportField($this->Search_Panel_Collapsed);
						if ($this->Filter_Panel_Collapsed->Exportable) $Doc->ExportField($this->Filter_Panel_Collapsed);
						if ($this->Show_Record_Number_On_List_Page->Exportable) $Doc->ExportField($this->Show_Record_Number_On_List_Page);
						if ($this->Show_Empty_Table_On_List_Page->Exportable) $Doc->ExportField($this->Show_Empty_Table_On_List_Page);
						if ($this->Rows_Vertical_Align_Top->Exportable) $Doc->ExportField($this->Rows_Vertical_Align_Top);
						if ($this->Action_Button_Alignment->Exportable) $Doc->ExportField($this->Action_Button_Alignment);
						if ($this->Show_Add_Success_Message->Exportable) $Doc->ExportField($this->Show_Add_Success_Message);
						if ($this->Show_Edit_Success_Message->Exportable) $Doc->ExportField($this->Show_Edit_Success_Message);
						if ($this->jQuery_Auto_Hide_Success_Message->Exportable) $Doc->ExportField($this->jQuery_Auto_Hide_Success_Message);
						if ($this->Use_Javascript_Message->Exportable) $Doc->ExportField($this->Use_Javascript_Message);
						if ($this->Login_Window_Type->Exportable) $Doc->ExportField($this->Login_Window_Type);
						if ($this->Forgot_Password_Window_Type->Exportable) $Doc->ExportField($this->Forgot_Password_Window_Type);
						if ($this->Change_Password_Window_Type->Exportable) $Doc->ExportField($this->Change_Password_Window_Type);
						if ($this->Registration_Window_Type->Exportable) $Doc->ExportField($this->Registration_Window_Type);
						if ($this->Show_Record_Number_On_Detail_Preview->Exportable) $Doc->ExportField($this->Show_Record_Number_On_Detail_Preview);
						if ($this->Show_Empty_Table_In_Detail_Preview->Exportable) $Doc->ExportField($this->Show_Empty_Table_In_Detail_Preview);
						if ($this->Detail_Preview_Table_Width->Exportable) $Doc->ExportField($this->Detail_Preview_Table_Width);
						if ($this->Password_Minimum_Length->Exportable) $Doc->ExportField($this->Password_Minimum_Length);
						if ($this->Password_Maximum_Length->Exportable) $Doc->ExportField($this->Password_Maximum_Length);
						if ($this->Password_Must_Contain_At_Least_One_Lower_Case->Exportable) $Doc->ExportField($this->Password_Must_Contain_At_Least_One_Lower_Case);
						if ($this->Password_Must_Comply_With_Minumum_Length->Exportable) $Doc->ExportField($this->Password_Must_Comply_With_Minumum_Length);
						if ($this->Password_Must_Comply_With_Maximum_Length->Exportable) $Doc->ExportField($this->Password_Must_Comply_With_Maximum_Length);
						if ($this->Password_Must_Contain_At_Least_One_Upper_Case->Exportable) $Doc->ExportField($this->Password_Must_Contain_At_Least_One_Upper_Case);
						if ($this->Password_Must_Contain_At_Least_One_Numeric->Exportable) $Doc->ExportField($this->Password_Must_Contain_At_Least_One_Numeric);
						if ($this->Password_Must_Contain_At_Least_One_Symbol->Exportable) $Doc->ExportField($this->Password_Must_Contain_At_Least_One_Symbol);
						if ($this->Password_Must_Be_Difference_Between_Old_And_New->Exportable) $Doc->ExportField($this->Password_Must_Be_Difference_Between_Old_And_New);
						if ($this->Reset_Password_Field_Options->Exportable) $Doc->ExportField($this->Reset_Password_Field_Options);
						if ($this->Export_Record_Options->Exportable) $Doc->ExportField($this->Export_Record_Options);
						if ($this->Show_Record_Number_On_Exported_List_Page->Exportable) $Doc->ExportField($this->Show_Record_Number_On_Exported_List_Page);
						if ($this->Use_Table_Setting_For_Export_Field_Caption->Exportable) $Doc->ExportField($this->Use_Table_Setting_For_Export_Field_Caption);
						if ($this->Use_Table_Setting_For_Export_Original_Value->Exportable) $Doc->ExportField($this->Use_Table_Setting_For_Export_Original_Value);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Option_ID->Exportable) $Doc->ExportField($this->Option_ID);
						if ($this->Option_Default->Exportable) $Doc->ExportField($this->Option_Default);
						if ($this->Default_Theme->Exportable) $Doc->ExportField($this->Default_Theme);
						if ($this->Show_Border_Layout->Exportable) $Doc->ExportField($this->Show_Border_Layout);
						if ($this->Show_Shadow_Layout->Exportable) $Doc->ExportField($this->Show_Shadow_Layout);
						if ($this->Menu_Horizontal->Exportable) $Doc->ExportField($this->Menu_Horizontal);
						if ($this->Show_Announcement->Exportable) $Doc->ExportField($this->Show_Announcement);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		$rs = ew_Execute("SELECT Option_ID FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		if ($rs && $rs->RecordCount()==1 && $rsnew["Option_Default"]=='N') {
			$this->setFailureMessage("There must be at least one default record in settings table. You cannot change this record!");
			return FALSE;
		}
		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		$rs = ew_Execute("SELECT Option_ID FROM ".MS_SETTINGS_TABLE);
		if ($rs && $rs->RecordCount()==1) {
			$this->setFailureMessage("There must be at least one record in settings table. You cannot delete this record!");
			return FALSE;
		}
		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
