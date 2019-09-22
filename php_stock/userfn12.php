<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {
	if (CurrentPageID() == "list") {
		CurrentPage()->ListOptions->UseImageAndText = TRUE;
		CurrentPage()->ListOptions->UseButtonGroup = TRUE;
		CurrentPage()->ListOptions->UseDropDownButton = TRUE;
		CurrentPage()->OtherOptions["addedit"]->UseImageAndText = TRUE;
		CurrentPage()->OtherOptions["detail"]->UseImageAndText = TRUE;
		CurrentPage()->OtherOptions["action"]->UseImageAndText = TRUE;
		CurrentPage()->OtherOptions["action"]->UseButtonGroup = TRUE;
		CurrentPage()->OtherOptions["action"]->UseDropDownButton = TRUE;
		CurrentPage()->ExportOptions->UseImageAndText = TRUE;
		CurrentPage()->ExportOptions->UseButtonGroup = TRUE;
		CurrentPage()->ExportOptions->UseDropDownButton = TRUE;
	}
	if (CurrentPageID() == "view") {
		CurrentPage()->OtherOptions["action"]->UseImageAndText = TRUE;
		CurrentPage()->OtherOptions["action"]->UseButtonGroup = TRUE;
		CurrentPage()->OtherOptions["action"]->UseDropDownButton = TRUE;
		CurrentPage()->ExportOptions->UseImageAndText = TRUE;
		CurrentPage()->ExportOptions->UseButtonGroup = TRUE;
		CurrentPage()->ExportOptions->UseDropDownButton = TRUE;
	}
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

function ValidateCustomerBalance($sCustomerID) {
	$val = ew_ExecuteScalar("SELECT SUM(Total_Balance) FROM a_sales WHERE Customer_ID = '".$sCustomerID."'");
	if ($val != "") {
		return $val;
	} else {
		return "0";
	}
}

function ValidateSupplierBalance($sSupplierID) {
	$val = ew_ExecuteScalar("SELECT SUM(Total_Balance) FROM a_purchases WHERE Supplier_ID = '".$sSupplierID."'");
	if ($val != "") {
		return $val;
	} else {
		return "0";
	}
}

function CheckStockAvailability($sSupplierID) {
	$val = ew_ExecuteScalar("SELECT SUM(Quantity) FROM a_stock_items WHERE Supplier_Number = '".$sSupplierID."'");
	if ($val != "") {
		return $val;
	} else {
		return "";
	}
}

function GetStartBalance($sType, $sID) {
	if ($sType == "sales") {
		$val = ew_ExecuteScalar("SELECT Total_Balance FROM a_sales WHERE Sales_Number = '".$sID."'");
		if ($val != "") {
			return abs($val);
		} else {
			return "0";
		}
	} elseif ($sType == "purchase") {
		$val = ew_ExecuteScalar("SELECT Total_Balance FROM a_purchases WHERE Purchase_Number = '".$sID."'");
		if ($val != "") {
			return abs($val);
		} else {
			return "0";
		}
	}
}

function GetRefID($sType, $sID) {
	if ($sType == "sales") {
		$val = ew_ExecuteScalar("SELECT Sales_Number FROM a_sales WHERE Customer_ID = '".$sID."'");
		if ($val != "") {
			return $val;
		} else {
			return "";
		}
	} elseif ($sType == "purchase") {
		$val = ew_ExecuteScalar("SELECT Purchase_Number FROM a_purchases WHERE Supplier_ID = '".$sID."'");
		if ($val != "") {
			return $val;
		} else {
			return "";
		}
	}
}

function GetSupplierNumber($Purchase_Number) {
	$val = ew_ExecuteScalar("SELECT Supplier_ID FROM a_purchases WHERE Purchase_Number = '".$Purchase_Number."'");
	if ($val != "") {
		return $val;
	} else {
		return "";
	}
}

function GetCustomerNumber($Sales_Number) {
	$val = ew_ExecuteScalar("SELECT Customer_ID FROM a_sales WHERE Sales_Number = '".$Sales_Number."'");
	if ($val != "") {
		return $val;
	} else {
		return "";
	}
}

function GetStockItemsQuantity($stock_number) {
	$val = ew_ExecuteScalar("SELECT Quantity FROM a_stock_items WHERE Stock_Number = '".$stock_number."'");
	if ($val != "") {
		return $val;
	} else {
		return "0";
	}
}

function GetNextSupplierNumber() {
	$sNextCode = "";
	$sLastCode = "";
	$value = ew_ExecuteScalar("SELECT Supplier_Number FROM a_suppliers ORDER BY Supplier_ID DESC");
	if ($value != "") {  
		$sLastCode = intval(substr($value, 9, 11));  
		$sLastCode = intval($sLastCode) + 1;  
		$sNextCode = "Supplier-" . sprintf('%011s', $sLastCode);  
	} else {  
		$sNextCode = "Supplier-00000000001";
	}
	return $sNextCode;
}

function GetNextStockNumber() {
	$sNextCode = "";
	$sLastCode = "";
	$value = ew_ExecuteScalar("SELECT Stock_Number FROM a_stock_items ORDER BY Stock_ID DESC");
	if ($value != "") {  
		$sLastCode = intval(substr($value, 6, 9));  
		$sLastCode = intval($sLastCode) + 1;  
		$sNextCode = "Stock-" . sprintf('%09s', $sLastCode);  
	} else {  
		$sNextCode = "Stock-000000001";
	}
	return $sNextCode;
}

function GetNextSalesNumber() {
	$sNextCode = "";
	$sLastCode = "";
	$value = ew_ExecuteScalar("SELECT Sales_Number FROM a_sales ORDER BY Sales_ID DESC");
	if ($value != "") {  
		$sLastCode = intval(substr($value, 6, 14));  
		$sLastCode = intval($sLastCode) + 1;  
		$sNextCode = "Sales-" . sprintf('%014s', $sLastCode);  
	} else {  
		$sNextCode = "Sales-00000000000001";
	}
	return $sNextCode;
}

function GetNextPurchaseNumber() {
	$sNextCode = "";
	$sLastCode = "";
	$value = ew_ExecuteScalar("SELECT Purchase_Number FROM a_purchases ORDER BY Purchase_ID DESC");
	if ($value != "") {  
		$sLastCode = intval(substr($value, 9, 11));  
		$sLastCode = intval($sLastCode) + 1;  
		$sNextCode = "Purchase-" . sprintf('%011s', $sLastCode);  
	} else {  
		$sNextCode = "Purchase-00000000001";
	}
	return $sNextCode;
}

function GetNextCustomerNumber() {
	$sNextCode = "";
	$sLastCode = "";
	$value = ew_ExecuteScalar("SELECT Customer_Number FROM a_customers ORDER BY Customer_ID DESC");
	if ($value != "") {  
		$sLastCode = intval(substr($value, 9, 11));  
		$sLastCode = intval($sLastCode) + 1;  
		$sNextCode = "Customer-" . sprintf('%011s', $sLastCode);  
	} else {  
		$sNextCode = "Customer-00000000001";
	}
	return $sNextCode;
}

// Begin of modification Load Sessions for Application Settings and User Preferences, by Masino Sinaga, September 22, 2014
function AutoSwitchTableWidthStyle() {
	if (MS_AUTO_SWITCH_TABLE_WIDTH_STYLE == TRUE) {
		if (@CurrentPage()->TotalRecs > 0 && @CurrentPage()->TotalRecs < 10 && CurrentPageID() == "list" && MS_TABLE_WIDTH_STYLE != '3') { 
			if (!isset($_SESSION['php_stock_runautoswitch'])) {
				$_SESSION['php_stock_runautoswitch'] = "1";
			} else {
				$_SESSION['php_stock_runautoswitch'] = "1";
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if ($_SESSION['php_stock_runautoswitch'] == "1") {
					@define("MS_TABLE_WIDTH_STYLE", "3", FALSE);
					$_SESSION['php_stock_runautoswitch'] = "0";
				} else {
					if (@$_SESSION['php_stock_userpreferences']["Table_Width_Style"]!="") {
						@define("MS_TABLE_WIDTH_STYLE", @$_SESSION['php_stock_userpreferences']["Table_Width_Style"], FALSE);
					} else {
						@define("MS_TABLE_WIDTH_STYLE", $_SESSION['php_stock_applicationsettings']["Table_Width_Style"], FALSE);
					}
				}
			} else {
				if ($_SESSION['php_stock_runautoswitch'] == "1") {
					@define("MS_TABLE_WIDTH_STYLE", "3", FALSE);
					$_SESSION['php_stock_runautoswitch'] = "0";
				} else {
					@define("MS_TABLE_WIDTH_STYLE", $_SESSION['php_stock_applicationsettings']["Table_Width_Style"], FALSE);
				}
			}
		} else {
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if (@$_SESSION['php_stock_userpreferences']["Table_Width_Style"]!="") {
					@define("MS_TABLE_WIDTH_STYLE", @$_SESSION['php_stock_userpreferences']["Table_Width_Style"], FALSE);
				} else {
					@define("MS_TABLE_WIDTH_STYLE", $_SESSION['php_stock_applicationsettings']["Table_Width_Style"], FALSE);
				}
			} else {
				if (@$_SESSION['php_stock_userpreferences']["Table_Width_Style"]!="") {
					@define("MS_TABLE_WIDTH_STYLE", @$_SESSION['php_stock_userpreferences']["Table_Width_Style"], FALSE);
				} else {
					@define("MS_TABLE_WIDTH_STYLE", $_SESSION['php_stock_applicationsettings']["Table_Width_Style"], FALSE);
				}
			}
		}
	}
}

// Begin of modification LoadApplicationSettings, by Masino Sinaga, September 22, 2014
function LoadApplicationSettings() {
	global $UserTableConn;

	// Parent array of all items, initialized if not already...
	if (!isset($_SESSION['php_stock_applicationsettings'])) {
		$_SESSION['php_stock_applicationsettings'] = array();
	}
	$sSql = "SELECT * FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'";
	$rs = $UserTableConn->Execute($sSql);
	if ($rs && $rs->RecordCount() > 0) {
		foreach($rs->fields as $fldname => $value) {
			$_SESSION['php_stock_applicationsettings'][$fldname] = $rs->fields($fldname);
		}

		//var_dump($_SESSION['php_stock_applicationsettings']);
	}
}

// End of modification LoadApplicationSettings, by Masino Sinaga, September 22, 2014
// Begin of modification LoadUserPreferences, by Masino Sinaga, September 22, 2014
function LoadUserPreferences() {
	global $UserTableConn;

	// Parent array of all items, initialized if not already...
	if (!isset($_SESSION['php_stock_userpreferences'])) {
	  $_SESSION['php_stock_userpreferences'] = array();
	}
	$sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
		$sSqlu = "SELECT Menu_Horizontal, Theme, Table_Width_Style, Scroll_Table_Width, Scroll_Table_Height, Language, Redirect_To_Last_Visited_Page_After_Login, 
					Current_URL, Rows_Vertical_Align_Top, Font_Name, Font_Size FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."";
	$rs = $UserTableConn->Execute($sSqlu);
	if ($rs && $rs->RecordCount() > 0) {
		foreach($rs->fields as $fldname => $value) {
			$_SESSION['php_stock_userpreferences'][$fldname] = $rs->fields($fldname);
		}

		//var_dump($_SESSION['php_stock_userpreferences']);
	}
}

// End of modification LoadUserPreferences, by Masino Sinaga, September 22, 2014
// End of modification Load Sessions for Application Settings and User Preferences, by Masino Sinaga, September 22, 2014
function Get_Root_URL() {
	return str_replace(substr(strrchr(ew_CurrentUrl(), "/"), 1), "", ew_DomainUrl().ew_CurrentUrl());
}

// Begin of modification My_Global_Check, by Masino Sinaga, July 3, 2013
function My_Global_Check() {
	global $Language, $gsLanguage, $Security, $UserTableConn;
	global $page_type;
    $page_type = "TABLE"; 
	if (!isset($_SESSION['php_stock_Root_URL'])) { 
		$_SESSION['php_stock_Root_URL'] = Get_Root_URL();
	}
	if (!isset($_SESSION['php_stock_views'])) { 
		$_SESSION['php_stock_views'] = 0;
	}
	$_SESSION['php_stock_views'] = $_SESSION['php_stock_views']+1;
	if ($_SESSION['php_stock_views'] == 1) {
		LoadApplicationSettings();
	}
	if (IsLoggedIn() && !IsSysAdmin()) {
		LoadUserPreferences();
	}

	// Begin of modification Application Settings, by Masino Sinaga, July 3, 2013
	// --------------------------------------------------------------------------

	if (MS_USE_CONSTANTS_IN_CONFIG_FILE==FALSE) {

		//$sSql = "SELECT * FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'";
		//$rs = ew_Execute($sSql);
		//$sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
		//$sSqlu = "SELECT Menu_Horizontal, Theme, Table_Width_Style, Scroll_Table_Width, Scroll_Table_Height, Language, Redirect_To_Last_Visited_Page_After_Login, 
		//			Rows_Vertical_Align_Top, Font_Name, Font_Size FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName.""; 
		//$rsu = ew_Execute($sSqlu);
		// if ($rs && $rs->RecordCount() > 0) {					

			if ($_SESSION['php_stock_applicationsettings']["Allow_User_Preferences"]=="Y") {
				@define("MS_ALLOW_USER_PREFERENCES", TRUE, FALSE);
			} else {
				@define("MS_ALLOW_USER_PREFERENCES", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Border_Layout"]=="Y") {
				@define("MS_SHOW_BORDER_LAYOUT", TRUE, FALSE);
			} else {
				@define("MS_SHOW_BORDER_LAYOUT", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Shadow_Layout"]=="Y") {
				@define("MS_SHOW_SHADOW_LAYOUT", TRUE, FALSE);
			} else {
				@define("MS_SHOW_SHADOW_LAYOUT", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Empty_Table_On_List_Page"]=="Y") {
				@define("MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Language_Selector_Visibility"]=="inheader") {
				@define("MS_LANGUAGE_SELECTOR_VISIBILITY", "inheader", FALSE);
			} elseif ($_SESSION['php_stock_applicationsettings']["Language_Selector_Visibility"]=="belowheader") { 
				@define("MS_LANGUAGE_SELECTOR_VISIBILITY", "belowheader", FALSE);
			} elseif ($_SESSION['php_stock_applicationsettings']["Language_Selector_Visibility"]=="hidethemall") { 
				@define("MS_LANGUAGE_SELECTOR_VISIBILITY", "hidethemall", FALSE);
			}  
			if ($_SESSION['php_stock_applicationsettings']["Text_Align_In_Header"]=="left") {
				@define("MS_TEXT_ALIGN_IN_HEADER", "left", FALSE);
			} elseif ($_SESSION['php_stock_applicationsettings']["Text_Align_In_Header"]=="center") {          
				@define("MS_TEXT_ALIGN_IN_HEADER", "center", FALSE);
			} elseif ($_SESSION['php_stock_applicationsettings']["Text_Align_In_Header"]=="right") {
				@define("MS_TEXT_ALIGN_IN_HEADER", "right", FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Language_Selector_Align"]=="autoadjust") {
				@define("MS_LANGUAGE_SELECTOR_ALIGN", MS_TEXT_ALIGN_IN_HEADER, FALSE);
			} else {
				@define("MS_LANGUAGE_SELECTOR_ALIGN", $_SESSION['php_stock_applicationsettings']["Language_Selector_Align"], FALSE);
			}     
			if ($_SESSION['php_stock_applicationsettings']["Show_Site_Title_In_Header"]=="Y") {
				@define("MS_SHOW_SITE_TITLE_IN_HEADER", TRUE, FALSE);
			} else {
				@define("MS_SHOW_SITE_TITLE_IN_HEADER", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Current_User_In_Header"]=="Y") {
				@define("MS_SHOW_CURRENT_USER_IN_HEADER", TRUE, FALSE);
			} else {
				@define("MS_SHOW_CURRENT_USER_IN_HEADER", FALSE, FALSE);
			}   
			if ($_SESSION['php_stock_applicationsettings']["Show_Entire_Header"]=="Y") {
				@define("MS_SHOW_ENTIRE_HEADER", TRUE, FALSE);
			} else {
				@define("MS_SHOW_ENTIRE_HEADER", FALSE, FALSE);
			}     
			if ($_SESSION['php_stock_applicationsettings']["Show_Entire_Footer"]=="Y") {
				@define("MS_SHOW_ENTIRE_FOOTER", TRUE, FALSE);
			} else {
				@define("MS_SHOW_ENTIRE_FOOTER", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Terms_And_Conditions_On_Footer"]=="Y") {
				@define("MS_SHOW_TERMS_AND_CONDITIONS_ON_FOOTER", TRUE, FALSE);
			} else {
				@define("MS_SHOW_TERMS_AND_CONDITIONS_ON_FOOTER", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Back_To_Top_On_Footer"]=="Y") {
				@define("MS_SHOW_BACKTOTOP_ON_FOOTER", TRUE, FALSE);
			} else {
				@define("MS_SHOW_BACKTOTOP_ON_FOOTER", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_About_Us_On_Footer"]=="Y") {
				@define("MS_SHOW_ABOUT_US_ON_FOOTER", TRUE, FALSE);
			} else {
				@define("MS_SHOW_ABOUT_US_ON_FOOTER", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Text_In_Footer"]=="Y") {
				@define("MS_SHOW_TEXT_IN_FOOTER", TRUE, FALSE);
			} else {
				@define("MS_SHOW_TEXT_IN_FOOTER", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Site_Title_Text_Style"]=="normal") {
				@define("MS_SITE_TITLE_TEXT_STYLE", "normal", FALSE);   
			} elseif ($_SESSION['php_stock_applicationsettings']["Site_Title_Text_Style"]=="capitalize") {
				@define("MS_SITE_TITLE_TEXT_STYLE", "capitalize", FALSE);
			} elseif ($_SESSION['php_stock_applicationsettings']["Site_Title_Text_Style"]=="uppercase") {
				@define("MS_SITE_TITLE_TEXT_STYLE", "uppercase", FALSE);    
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if (@$_SESSION['php_stock_userpreferences']["Menu_Horizontal"]=="Y") {
					@define("MS_MENU_HORIZONTAL", TRUE, FALSE);
				} elseif (@$_SESSION['php_stock_userpreferences']["Menu_Horizontal"]=="N") {
					@define("MS_MENU_HORIZONTAL", FALSE, FALSE);
				} else {
					if ( $_SESSION['php_stock_applicationsettings']["Menu_Horizontal"]=="Y" ) {
						@define("MS_MENU_HORIZONTAL", TRUE, FALSE);
					} else {
						@define("MS_MENU_HORIZONTAL", FALSE, FALSE);
					}
				}
			} else {
				if ( $_SESSION['php_stock_applicationsettings']["Menu_Horizontal"]=="Y" ) {
					@define("MS_MENU_HORIZONTAL", TRUE, FALSE);
				} else {
					@define("MS_MENU_HORIZONTAL", FALSE, FALSE);
				}
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if (@$_SESSION['php_stock_userpreferences']["Rows_Vertical_Align_Top"]=="Y") {
					@define("MS_ROWS_VERTICAL_ALIGN_TOP", TRUE, FALSE);
				} elseif (@$_SESSION['php_stock_userpreferences']["Rows_Vertical_Align_Top"]=="N") {
					@define("MS_ROWS_VERTICAL_ALIGN_TOP", FALSE, FALSE);
				} else {
					if ( $_SESSION['php_stock_applicationsettings']["Rows_Vertical_Align_Top"]=="Y" ) {
						@define("MS_ROWS_VERTICAL_ALIGN_TOP", TRUE, FALSE);
					} else {
						@define("MS_ROWS_VERTICAL_ALIGN_TOP", FALSE, FALSE);
					}
				}
			} else {
				if ( $_SESSION['php_stock_applicationsettings']["Rows_Vertical_Align_Top"]=="Y" ) {
					@define("MS_ROWS_VERTICAL_ALIGN_TOP", TRUE, FALSE);
				} else {
					@define("MS_ROWS_VERTICAL_ALIGN_TOP", FALSE, FALSE);
				}
			}
			@define("MS_VERTICAL_MENU_WIDTH", $_SESSION['php_stock_applicationsettings']["Vertical_Menu_Width"], FALSE);
			@define("MS_LOGO_WIDTH", $_SESSION['php_stock_applicationsettings']["Logo_Width"], FALSE);  
			if (MS_AUTO_SWITCH_TABLE_WIDTH_STYLE == FALSE) { // just in case auto switch table is not used!
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if (@$_SESSION['php_stock_userpreferences']["Table_Width_Style"]!="") {
					@define("MS_TABLE_WIDTH_STYLE", @$_SESSION['php_stock_userpreferences']["Table_Width_Style"], FALSE);
				} else {
					@define("MS_TABLE_WIDTH_STYLE", $_SESSION['php_stock_applicationsettings']["Table_Width_Style"], FALSE);
				}
			} else {
				@define("MS_TABLE_WIDTH_STYLE", $_SESSION['php_stock_applicationsettings']["Table_Width_Style"], FALSE);
			}
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if (@$_SESSION['php_stock_userpreferences']["Scroll_Table_Width"]>0) {
					@define("MS_SCROLL_TABLE_WIDTH", @$_SESSION['php_stock_userpreferences']["Scroll_Table_Width"], FALSE);
				} else {
					@define("MS_SCROLL_TABLE_WIDTH", $_SESSION['php_stock_applicationsettings']["Scroll_Table_Width"], FALSE);
				}
			} else {
				@define("MS_SCROLL_TABLE_WIDTH", $_SESSION['php_stock_applicationsettings']["Scroll_Table_Width"], FALSE);
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if (@$_SESSION['php_stock_userpreferences']["Scroll_Table_Height"]>0) {
					@define("MS_SCROLL_TABLE_HEIGHT", @$_SESSION['php_stock_userpreferences']["Scroll_Table_Height"], FALSE);
				} else {
					@define("MS_SCROLL_TABLE_HEIGHT", $_SESSION['php_stock_applicationsettings']["Scroll_Table_Height"], FALSE);
				}
			} else {
				@define("MS_SCROLL_TABLE_HEIGHT", $_SESSION['php_stock_applicationsettings']["Scroll_Table_Height"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["User_Auto_Logout_After_Idle_In_Minutes"]>0) {
				@define("MS_AUTO_LOGOUT_AFTER_IDLE_IN_MINUTES", $_SESSION['php_stock_applicationsettings']["User_Auto_Logout_After_Idle_In_Minutes"], FALSE);
			}

			// This is a must to override the menu constants in the beginning, by Masino Sinaga, July 23, 2014
			if (MS_MENU_HORIZONTAL) {
				@define("EW_MENUBAR_ID", "ewHorizMenu", FALSE);
				@define("EW_MENUBAR_CLASSNAME", "navbar navbar-default", FALSE);
				@define("EW_MENUBAR_INNER_CLASSNAME", "", FALSE);
				@define("EW_MENU_CLASSNAME", "nav navbar-nav", FALSE);
				@define("EW_SUBMENU_CLASSNAME", "dropdown-menu", FALSE);
				@define("EW_SUBMENU_DROPDOWN_IMAGE", " <b class=\"caret\"></b>", FALSE);
				@define("EW_SUBMENU_DROPDOWN_ICON_CLASSNAME", "", FALSE);
				@define("EW_MENU_DIVIDER_CLASSNAME", "divider", FALSE);
				@define("EW_MENU_ITEM_CLASSNAME", "dropdown", FALSE);
				@define("EW_SUBMENU_ITEM_CLASSNAME", "dropdown-submenu", FALSE);
				@define("EW_MENU_ACTIVE_ITEM_CLASS", "active", FALSE);
				@define("EW_SUBMENU_ACTIVE_ITEM_CLASS", "active", FALSE);
				@define("EW_MENU_ROOT_GROUP_TITLE_AS_SUBMENU", TRUE, FALSE);
				@define("EW_SHOW_RIGHT_MENU", TRUE, FALSE);
			} else {
				@define("EW_MENUBAR_ID", "RootMenu", FALSE);
				@define("EW_MENUBAR_CLASSNAME", "", FALSE);
				@define("EW_MENU_CLASSNAME", "dropdown-menu", FALSE);
				@define("EW_SUBMENU_CLASSNAME", "dropdown-menu", FALSE);
				@define("EW_SUBMENU_DROPDOWN_IMAGE", "", FALSE);
				@define("EW_SUBMENU_DROPDOWN_ICON_CLASSNAME", "", FALSE);
				@define("EW_MENU_DIVIDER_CLASSNAME", "divider", FALSE);
				@define("EW_MENU_ITEM_CLASSNAME", "dropdown-submenu", FALSE);
				@define("EW_SUBMENU_ITEM_CLASSNAME", "dropdown-submenu", FALSE);
				@define("EW_MENU_ACTIVE_ITEM_CLASS", "active", FALSE);
				@define("EW_SUBMENU_ACTIVE_ITEM_CLASS", "active", FALSE);
				@define("EW_MENU_ROOT_GROUP_TITLE_AS_SUBMENU", FALSE, FALSE);
				@define("EW_SHOW_RIGHT_MENU", FALSE, FALSE);
			}
			@define("EW_MENUBAR_BRAND", "", FALSE);
			@define("EW_MENUBAR_BRAND_HYPERLINK", "", FALSE);

			// This is a must to override the menu constants in the beginning, by Masino Sinaga, July 23, 2014
			if (MS_MENU_HORIZONTAL) {
				@define("MS_TOTAL_WIDTH", MS_SCROLL_TABLE_WIDTH + 40, FALSE);
			} else {  
				@define("MS_TOTAL_WIDTH", MS_SCROLL_TABLE_WIDTH + MS_VERTICAL_MENU_WIDTH - 50, FALSE);
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if ( @$_SESSION['php_stock_userpreferences']["Theme"]!="" ) {
					@define("EW_PROJECT_STYLESHEET_FILENAME", 'phpcss/'.@$_SESSION['php_stock_userpreferences']["Theme"], FALSE);
				} else {
					@define("EW_PROJECT_STYLESHEET_FILENAME", 'phpcss/'.$_SESSION['php_stock_applicationsettings']["Default_Theme"], FALSE);
				}
			} else {
				@define("EW_PROJECT_STYLESHEET_FILENAME", 'phpcss/'.$_SESSION['php_stock_applicationsettings']["Default_Theme"], FALSE);
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if ( @$_SESSION['php_stock_userpreferences']["Font_Name"]!="" ) {
					@define("MS_FONT_NAME", "".@$_SESSION['php_stock_userpreferences']["Font_Name"]."", FALSE);
				} else {
					@define("MS_FONT_NAME", "".$_SESSION['php_stock_applicationsettings']["Font_Name"]."", FALSE);
				}
			} else {
				@define("MS_FONT_NAME", "".$_SESSION['php_stock_applicationsettings']["Font_Name"]."", FALSE);
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if ( @$_SESSION['php_stock_userpreferences']["Font_Size"]!="" ) {
					@define("MS_FONT_SIZE", "".@$_SESSION['php_stock_userpreferences']["Font_Size"]."", FALSE);
				} else {
					@define("MS_FONT_SIZE", "".$_SESSION['php_stock_applicationsettings']["Font_Size"]."", FALSE);
				}
			} else {
				@define("MS_FONT_SIZE", "".$_SESSION['php_stock_applicationsettings']["Font_Size"]."", FALSE);
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if ( @$_SESSION['php_stock_userpreferences']["Language"]!="" ) {
					@define("EW_LANGUAGE_DEFAULT_ID", 'phpcss/'.@$_SESSION['php_stock_userpreferences']["Language"], FALSE);
				} else {
					@define("EW_LANGUAGE_DEFAULT_ID", 'phpcss/'.$_SESSION['php_stock_applicationsettings']["Default_Language"], FALSE);
				}
			} else {
				@define("EW_LANGUAGE_DEFAULT_ID", 'phpcss/'.$_SESSION['php_stock_applicationsettings']["Default_Language"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Default_Timezone"]!="") {
				$DEFAULT_TIME_ZONE = $_SESSION['php_stock_applicationsettings']["Default_Timezone"];
			}
			if ($_SESSION['php_stock_applicationsettings']["Maintenance_Finish_DateTime"]!="") {
				@define("MS_MAINTENANCE_END_DATETIME", "".$_SESSION['php_stock_applicationsettings']["Maintenance_Finish_DateTime"]."", FALSE);
			}
			if (MS_ALLOW_USER_PREFERENCES==TRUE) {
				if (@$_SESSION['php_stock_userpreferences']["Redirect_To_Last_Visited_Page_After_Login"]=="Y") {
					@define("MS_REDIRECT_TO_LAST_VISITED_PAGE_AFTER_LOGIN", TRUE, FALSE);
				} elseif (@$_SESSION['php_stock_userpreferences']["Redirect_To_Last_Visited_Page_After_Login"]=="N") {
					@define("MS_REDIRECT_TO_LAST_VISITED_PAGE_AFTER_LOGIN", FALSE, FALSE);
				} else {
					if ($_SESSION['php_stock_applicationsettings']["Redirect_To_Last_Visited_Page_After_Login"]=="Y") {
						@define("MS_REDIRECT_TO_LAST_VISITED_PAGE_AFTER_LOGIN", TRUE, FALSE);
					} elseif ($_SESSION['php_stock_applicationsettings']["Redirect_To_Last_Visited_Page_After_Login"]=="N") {
						@define("MS_REDIRECT_TO_LAST_VISITED_PAGE_AFTER_LOGIN", FALSE, FALSE);
					}
				}
			} else {
				if ($_SESSION['php_stock_applicationsettings']["Redirect_To_Last_Visited_Page_After_Login"]=="Y") {
					@define("MS_REDIRECT_TO_LAST_VISITED_PAGE_AFTER_LOGIN", TRUE, FALSE);
				} elseif ($_SESSION['php_stock_applicationsettings']["Redirect_To_Last_Visited_Page_After_Login"]=="N") {
					@define("MS_REDIRECT_TO_LAST_VISITED_PAGE_AFTER_LOGIN", FALSE, FALSE);
				}
			}
			if ($_SESSION['php_stock_applicationsettings']["User_Login_Maximum_Retry"]>0) {
				@define("EW_USER_PROFILE_MAX_RETRY", $_SESSION['php_stock_applicationsettings']["User_Login_Maximum_Retry"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["User_Login_Retry_Lockout"]>0) {
				@define("EW_USER_PROFILE_RETRY_LOCKOUT", $_SESSION['php_stock_applicationsettings']["User_Login_Retry_Lockout"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Record_Number_On_List_Page"]=="Y") {
				@define("MS_SHOW_RECORD_NUMBER_COLUMN_ON_LIST", TRUE, FALSE);
			} else {
				@define("MS_SHOW_RECORD_NUMBER_COLUMN_ON_LIST", FALSE, FALSE);      
			}						
			if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_COLLAPSED == FALSE) {
				if ($_SESSION['php_stock_applicationsettings']["Search_Panel_Collapsed"]=="Y") {
					@define("MS_SEARCH_PANEL_COLLAPSED", "1", FALSE);
				} else {
					@define("MS_SEARCH_PANEL_COLLAPSED", "0", FALSE);      
				}
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Add_Success_Message"]=="Y") {
				@define("MS_SHOW_ADD_SUCCESS_MESSAGE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_ADD_SUCCESS_MESSAGE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Edit_Success_Message"]=="Y") {
				@define("MS_SHOW_EDIT_SUCCESS_MESSAGE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_EDIT_SUCCESS_MESSAGE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Record_Number_On_Detail_Preview"]=="Y") {
				@define("MS_SHOW_RECORD_NUMBER_COLUMN_ON_DETAIL_PREVIEW", TRUE, FALSE);
			} else {
				@define("MS_SHOW_RECORD_NUMBER_COLUMN_ON_DETAIL_PREVIEW", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Empty_Table_In_Detail_Preview"]=="Y") {
				@define("MS_SHOW_EMPTY_TABLE_IN_DETAIL_PREVIEW", TRUE, FALSE);
			} else {
				@define("MS_SHOW_EMPTY_TABLE_IN_DETAIL_PREVIEW", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Detail_Preview_Table_Width"]>=0) {
				@define("MS_PREVIEW_TABLE_WIDTH", $_SESSION['php_stock_applicationsettings']["Detail_Preview_Table_Width"], FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Minimum_Length"]>0) {
				@define("MS_PASSWORD_MINIMUM_LENGTH", $_SESSION['php_stock_applicationsettings']["Password_Minimum_Length"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Maximum_Length"]>0) {
				@define("MS_PASSWORD_MAXIMUM_LENGTH", $_SESSION['php_stock_applicationsettings']["Password_Maximum_Length"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Must_Comply_With_Minumum_Length"]>0) {
				@define("MS_PASSWORD_MUST_COMPLY_WITH_MIN_LENGTH", $_SESSION['php_stock_applicationsettings']["Password_Must_Comply_With_Minumum_Length"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Must_Comply_With_Maximum_Length"]>0) {
				@define("MS_PASSWORD_MUST_COMPLY_WITH_MAX_LENGTH", $_SESSION['php_stock_applicationsettings']["Password_Must_Comply_With_Maximum_Length"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Must_Contain_At_Least_One_Lower_Case"]=="Y") {
				@define("MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_LETTER", TRUE, FALSE);
			} else {
				@define("MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_LETTER", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Must_Contain_At_Least_One_Upper_Case"]=="Y") {
				@define("MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_CAPS", TRUE, FALSE);
			} else {
				@define("MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_CAPS", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Must_Contain_At_Least_One_Numeric"]=="Y") {
				@define("MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_NUMBER", TRUE, FALSE);
			} else {
				@define("MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_NUMBER", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Must_Contain_At_Least_One_Symbol"]=="Y") {
				@define("MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_SYMBOL", TRUE, FALSE);
			} else {
				@define("MS_PASSWORD_MUST_INCLUDE_AT_LEAST_ONE_SYMBOL", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Password_Must_Be_Difference_Between_Old_And_New"]=="Y") {
				@define("MS_PASSWORD_MUST_DIFFERENT_OLD_AND_NEW", TRUE, FALSE);
			} else {
				@define("MS_PASSWORD_MUST_DIFFERENT_OLD_AND_NEW", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Announcement"]=="Y") {
				@define("MS_SHOW_ANNOUNCEMENT", TRUE, FALSE);
			} else {
				@define("MS_SHOW_ANNOUNCEMENT", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["jQuery_Auto_Hide_Success_Message"]=="Y") {
				@define("MS_AUTO_HIDE_SUCCESS_MESSAGE", TRUE, FALSE);
			} else {
				@define("MS_AUTO_HIDE_SUCCESS_MESSAGE", FALSE, FALSE);      
			}			
			if ($_SESSION['php_stock_applicationsettings']["Maintenance_Mode"]=="Y") {
				@define("MS_MAINTENANCE_MODE", TRUE, FALSE);        
			} else {
				@define("MS_MAINTENANCE_MODE", FALSE, FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Auto_Normal_After_Maintenance"]=="Y") {
				@define("MS_AUTO_NORMAL_AFTER_MAINTENANCE", TRUE, FALSE);
			} else {
				@define("MS_AUTO_NORMAL_AFTER_MAINTENANCE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["SMTP_Server"]!="") {
				@define("EW_SMTP_SERVER", $_SESSION['php_stock_applicationsettings']["SMTP_Server"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["SMTP_Server_Port"]!="") {
				@define("EW_SMTP_SERVER_PORT", $_SESSION['php_stock_applicationsettings']["SMTP_Server_Port"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["SMTP_Server_Username"]!="") {
				@define("EW_SMTP_SERVER_USERNAME", $_SESSION['php_stock_applicationsettings']["SMTP_Server_Username"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["SMTP_Server_Password"]!="") {
				@define("EW_SMTP_SERVER_PASSWORD", $_SESSION['php_stock_applicationsettings']["SMTP_Server_Password"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Sender_Email"]!="") {
				@define("EW_SENDER_EMAIL", $_SESSION['php_stock_applicationsettings']["Sender_Email"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Recipient_Email"]!="") {      
				@define("EW_RECIPIENT_EMAIL", $_SESSION['php_stock_applicationsettings']["Recipient_Email"], FALSE);
			} 
			if ($_SESSION['php_stock_applicationsettings']["Demo_Mode"]=="Y") {
				@define("MS_DEMO_MODE", TRUE, FALSE);
			} else  {         
				@define("MS_DEMO_MODE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Page_Processing_Time"]=="Y") {
				@define("MS_PAGE_PROCESSING_TIME", TRUE, FALSE);
			} else  {         
				@define("MS_PAGE_PROCESSING_TIME", FALSE, FALSE);      
			}   
			if ($_SESSION['php_stock_applicationsettings']["Allow_User_To_Register"]=="Y") {
				@define("MS_USER_REGISTRATION", TRUE, FALSE);
			} else {
				@define("MS_USER_REGISTRATION", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Terms_And_Conditions_On_Registration_Page"]=="Y") {
				@define("MS_SHOW_TERMS_AND_CONDITIONS_ON_REGISTRATION_PAGE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_TERMS_AND_CONDITIONS_ON_REGISTRATION_PAGE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Captcha_On_Registration_Page"]=="Y") {
				@define("MS_SHOW_CAPTCHA_ON_REGISTRATION_PAGE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_CAPTCHA_ON_REGISTRATION_PAGE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Captcha_On_Login_Page"]=="Y") {
				@define("MS_SHOW_CAPTCHA_ON_LOGIN_PAGE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_CAPTCHA_ON_LOGIN_PAGE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Captcha_On_Forgot_Password_Page"]=="Y") {
				@define("MS_SHOW_CAPTCHA_ON_FORGOT_PASSWORD_PAGE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_CAPTCHA_ON_FORGOT_PASSWORD_PAGE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Captcha_On_Change_Password_Page"]=="Y") {
				@define("MS_SHOW_CAPTCHA_ON_CHANGE_PASSWORD_PAGE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_CAPTCHA_ON_CHANGE_PASSWORD_PAGE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Suspend_New_User_Account"]=="Y") {
				@define("MS_SUSPEND_NEW_USER_ACCOUNT", TRUE, FALSE);
			} else {
				@define("MS_SUSPEND_NEW_USER_ACCOUNT", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["User_Need_Activation_After_Registered"]=="Y") {
				@define("MS_USER_NEED_ACTIVATION", TRUE, FALSE);
			} else {
				@define("MS_USER_NEED_ACTIVATION", FALSE, FALSE);      
			}   
			if ($_SESSION['php_stock_applicationsettings']["Enable_Password_Expiry"]=="Y") {
				@define("MS_ENABLE_PASSWORD_EXPIRY", TRUE, FALSE);
			} else  {         
				@define("MS_ENABLE_PASSWORD_EXPIRY", FALSE, FALSE);      
			}  
			if ($_SESSION['php_stock_applicationsettings']["Password_Expiry_In_Days"]>0) {
				@define("EW_USER_PROFILE_PASSWORD_EXPIRE", $_SESSION['php_stock_applicationsettings']["Password_Expiry_In_Days"], FALSE);
			} 
			if ($_SESSION['php_stock_applicationsettings']["Default_Record_Per_Page"]!=0) {
				@define("MS_TABLE_RECPERPAGE_VALUE", $_SESSION['php_stock_applicationsettings']["Default_Record_Per_Page"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Maximum_Selected_Records"]!=0) {
				@define("MS_TABLE_MAXIMUM_SELECTED_RECORDS", $_SESSION['php_stock_applicationsettings']["Maximum_Selected_Records"], FALSE);
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_PageNum_If_Record_Not_Over_Pagesize"]=="Y") {
				@define("MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE", TRUE, FALSE);
			} else {
				@define("MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE", FALSE, FALSE);      
			} 
			if ($_SESSION['php_stock_applicationsettings']["Selectable_Records_Per_Page"]<>"") {
				@define("MS_TABLE_SELECTABLE_REC_PER_PAGE_LIST", $_SESSION['php_stock_applicationsettings']["Selectable_Records_Per_Page"], FALSE);
			}  
			if ($_SESSION['php_stock_applicationsettings']["Pagination_Style"]=="1") {
				@define("MS_PAGINATION_STYLE", 1, FALSE);
			} else  {
				@define("MS_PAGINATION_STYLE", 2, FALSE);      
			} 
			if ($_SESSION['php_stock_applicationsettings']["Pagination_Position"]=="1") {
				@define("MS_PAGINATION_POSITION", 1, FALSE);
			} elseif ($_SESSION['php_stock_applicationsettings']["Pagination_Position"]=="2") {
				@define("MS_PAGINATION_POSITION", 2, FALSE);  
			} else  {
				@define("MS_PAGINATION_POSITION", 3, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Export_Record_Options"]=="currentpage") {
				@define("MS_EXPORT_RECORD_OPTIONS", "currentpage", FALSE);
			} elseif ($_SESSION['php_stock_applicationsettings']["Export_Record_Options"]=="allpages") {          
				@define("MS_EXPORT_RECORD_OPTIONS", "allpages", FALSE);    
			} else { // default, including blank
				@define("MS_EXPORT_RECORD_OPTIONS", "selectedrecords", FALSE);   
			}
			if ($_SESSION['php_stock_applicationsettings']["Show_Record_Number_On_Exported_List_Page"]=="Y") {
				@define("MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST", TRUE, FALSE);
			} else  {
				@define("MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Use_Table_Setting_For_Export_Field_Caption"]=="Y") {
				@define("MS_USE_TABLE_SETTING_FOR_EXPORT_FIELD_CAPTION", TRUE, FALSE);
			} else  {
				@define("MS_USE_TABLE_SETTING_FOR_EXPORT_FIELD_CAPTION", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Use_Table_Setting_For_Export_Original_Value"]=="Y") {
				@define("MS_USE_TABLE_SETTING_FOR_EXPORT_ORIGINAL_VALUE", TRUE, FALSE);
			} else  {
				@define("MS_USE_TABLE_SETTING_FOR_EXPORT_ORIGINAL_VALUE", FALSE, FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Use_Javascript_Message"]=="1") {
				@define("MS_USE_JAVASCRIPT_MESSAGE", 1, FALSE); // for javascript compatiblity,  we use 1 or 0, not TRUE or FALSE!
			} else  {
				@define("MS_USE_JAVASCRIPT_MESSAGE", 0, FALSE); // for javascript compatiblity,  we use 1 or 0, not TRUE or FALSE!     
			}
			if ($_SESSION['php_stock_applicationsettings']["Login_Window_Type"]=="default") {
				@define("MS_LOGIN_WINDOW_TYPE", "default", FALSE);
			} else {
				@define("MS_LOGIN_WINDOW_TYPE", "popup", FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Forgot_Password_Window_Type"]=="default") {
				@define("MS_FORGOTPWD_WINDOW_TYPE", "default", FALSE);
			} else {
				@define("MS_FORGOTPWD_WINDOW_TYPE", "popup", FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Change_Password_Window_Type"]=="default") {
				@define("MS_CHANGEPWD_WINDOW_TYPE", "default", FALSE);
			} else {
				@define("MS_CHANGEPWD_WINDOW_TYPE", "popup", FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Registration_Window_Type"]=="default") {
				@define("MS_REGISTER_WINDOW_TYPE", "default", FALSE);
			} else {
				@define("MS_REGISTER_WINDOW_TYPE", "popup", FALSE);      
			}
			if ($_SESSION['php_stock_applicationsettings']["Reset_Password_Field_Options"]=="Email") {
				@define("MS_KNOWN_FIELD_OPTIONS", "Email", FALSE);
			} elseif ($_SESSION['php_stock_applicationsettings']["Reset_Password_Field_Options"]=="Username") {          
				@define("MS_KNOWN_FIELD_OPTIONS", "Username", FALSE);    
			} else { // default, including blank
				@define("MS_KNOWN_FIELD_OPTIONS", "EmailOrUsername", FALSE);   
			}
			if ($_SESSION['php_stock_applicationsettings']["Action_Button_Alignment"]=="Left") {
				@define("MS_ACTION_BUTTON_ALIGNMENT", "Left", FALSE);
			} else {
				@define("MS_ACTION_BUTTON_ALIGNMENT", "Right", FALSE);      
			}

		// }
	}

	// ------------------------------------------------------------------------
	// End of modification Application Settings, by Masino Sinaga, July 3, 2013
	// Begin of modification Announcement in All Pages, by Masino Sinaga, May 12, 2012   

	if (MS_SHOW_ANNOUNCEMENT) {
	  if (MS_SEPARATED_ANNOUNCEMENT) {
		$sSqla = "SELECT * FROM ".MS_ANNOUNCEMENT_TABLE." WHERE Auto_Publish = 'Y' AND Language = '$gsLanguage'";
		$rsa = $UserTableConn->Execute($sSqla);
		if ($rsa && $rsa->RecordCount() > 0) {
			$today_begin = date('Y-m-d')." 00:00:01";
			$today_end = date('Y-m-d')." 23:59:59";
			$sIDAnnouncement = "";
			while (!$rsa->EOF) {
				if (IsDateBetweenTwoDates($today_begin, $today_end, $rsa->fields("Date_Start"), $rsa->fields("Date_End"))) {
					$sIDAnnouncement = $rsa->fields("Announcement_ID");
					$UserTableConn->Execute("UPDATE ".MS_ANNOUNCEMENT_TABLE." SET Is_Active = 'N'"); // reset all become Not Active
					$UserTableConn->Execute("UPDATE ".MS_ANNOUNCEMENT_TABLE." SET Is_Active = 'Y' 
								WHERE Announcement_ID = ".$sIDAnnouncement." 
								OR Translated_ID = ".$sIDAnnouncement); // set Active for the current published announcement
					@define("MS_ANNOUNCEMENT_TEXT", $rsa->fields("Message"), FALSE);
				}
				$rsa->MoveNext();
			}
			$rsa->Close();
		} else {
			$sSqla = "SELECT Message FROM ".MS_ANNOUNCEMENT_TABLE." WHERE Language = '$gsLanguage' AND Is_Active = 'Y'";
			$rsa = $UserTableConn->Execute($sSqla);
			@define("MS_ANNOUNCEMENT_TEXT", $rsa->fields("Message"), FALSE);
		}
	  } else {
		$sSqll = "SELECT Announcement_Text FROM ".MS_LANGUAGES_TABLE." WHERE Language_Code = '$gsLanguage'";
		$rsl = $UserTableConn->Execute($sSqll);
		@define("MS_ANNOUNCEMENT_TEXT", $rsl->fields("Announcement_Text"), FALSE);
	  }
	}

	// End of modification Announcement in All Pages, by Masino Sinaga, May 12, 2012
	// Begin of modification Maintenance Mode, by Masino Sinaga, May 12, 2012    

	if (MS_MAINTENANCE_MODE==TRUE) {
		$date_now = date("Y-m-d H:i:s");
		$date_end = MS_MAINTENANCE_END_DATETIME;
		$cssfile = '<link rel="stylesheet" type="text/css" href="'.EW_PROJECT_STYLESHEET_FILENAME.'">';
		$cssfile .= '<link rel="stylesheet" type="text/css" href="bootstrap3/css/bootstrap-'.MS_FONT_NAME.'-'. MS_FONT_SIZE.'.css">';
		$cssfile .= '<link rel="stylesheet" type="text/css" href="phpcss/customcss-'.MS_FONT_SIZE.'.css">';
		if (!$Security->CanAdmin()) {
			if ((ew_CurrentPage()!="index.php") && (ew_CurrentPage()!="logout.php") && (ew_CurrentPage()!="login.php")) {
				if ($date_end != "") { // Assuming end of maintenance date/time is valid
					if ($date_end<=$date_now) {
						if (MS_AUTO_NORMAL_AFTER_MAINTENANCE==TRUE) {

							// Normal mode here, nothing to do here; just give your user an access!
						} else {

							// Still in maintenance mode, and end of date/time not reached yet, even Auto Normal is False
							echo '<head><title>'.$Language->Phrase("MaintenanceTitle").'</title>';
							echo $cssfile;
							echo '<meta name="generator" content="PHPMaker v12.0.3">
</head>';
							echo '<div class="box-maintenance alert-danger">'.ew_JsEncode($Language->Phrase("MaintenanceUserMessageUnknown")).' <br><a href="logout.php">'.$Language->Phrase("GoBack").'</a></div>';
							exit;
						}
					} else {

						// Still in maintenance mode, even end of date/time has been reached
						echo '<head><title>'.$Language->Phrase("MaintenanceTitle").'</title>';
						echo $cssfile;
						echo '<meta name="generator" content="PHPMaker v12.0.3">
</head>';
						echo '<div class="box-maintenance alert-danger">'.ew_JsEncode($Language->Phrase("MaintenanceUserMessage")).' '.Duration(date("Y-m-d H:i:s"), $date_end).'<br><a href="logout.php">'.$Language->Phrase("GoBack").'</a></div>';
						exit;
					}
				} else {

					// Still in maintenance mode, the date/time value is blank!
					echo '<head><title>'.$Language->Phrase("MaintenanceTitle").'</title>';
					echo $cssfile;
					echo '<meta name="generator" content="PHPMaker v12.0.3">
</head>';
					echo '<div class="box-maintenance alert-danger">'.ew_JsEncode($Language->Phrase("MaintenanceUserMessageUnknown")).' <br><a href="logout.php">'.$Language->Phrase("GoBack").'</a></div>';
					exit;                
				}
			} else {

				// DO NOTHING HERE !!!                
				if ($date_end != "") { // Assuming end of maintenance date/time is valid
					if ($date_end<=$date_now) {
						if (MS_AUTO_NORMAL_AFTER_MAINTENANCE==TRUE) {
							@define("MS_MAINTENANCE_TEXT", ew_JsEncode($Language->Phrase("MaintenanceUserMessageUnknown")).' &nbsp;<a href="logout.php">'.$Language->Phrase("GoBack").'</a>', FALSE);

							// Normal mode here, just give your user an access!
						} else {

							// Still in maintenance mode, and end of date/time not reached yet, even Auto Normal is False
							@define("MS_MAINTENANCE_TEXT", ew_JsEncode($Language->Phrase("MaintenanceUserMessageUnknown")).' &nbsp;<a href="logout.php">'.$Language->Phrase("GoBack").'</a>', FALSE);
						}
					} else {

						// Still in maintenance mode, even end of date/time has been reached
						@define("MS_MAINTENANCE_TEXT", ew_JsEncode($Language->Phrase("MaintenanceUserMessage")).' '.Duration(date("Y-m-d H:i:s"), $date_end).'&nbsp;&nbsp;<a href="logout.php">'.$Language->Phrase("GoBack").'</a>', FALSE);
					}
				} else {

					// Still in maintenance mode, the date/time value is blank!
					@define("MS_MAINTENANCE_TEXT", ew_JsEncode($Language->Phrase("MaintenanceUserMessageUnknown")).' &nbsp;&nbsp;<a href="logout.php">'.$Language->Phrase("GoBack").'</a>', FALSE);
				}                
			}
		} else {  // Start from here, Maintenance Mode for Admin!
			if ((ew_CurrentPage()!="index.php") && (ew_CurrentPage()!="logout.php") && (ew_CurrentPage()!="login.php")) {
				if ($date_end != "") { // Assuming end of maintenance date/time is valid
					if ($date_end<=$date_now) {
						if (MS_AUTO_NORMAL_AFTER_MAINTENANCE==TRUE) {
							@define("MS_MAINTENANCE_TEXT", ew_JsEncode($Language->Phrase("MaintenanceUserMessageError")).' &nbsp;<a href="logout.php">'.$Language->Phrase("GoBack").'</a>', FALSE);
						} else {

						  // We are using this, in order to avoid the css conflict, so we use constant help just for admin!
						  @define("MS_MAINTENANCE_TEXT", ew_JsEncode($Language->Phrase("MaintenanceAdminMessageUnknown")).' ', FALSE);
						}
					} else {

						// We are using this, in order to avoid the css conflict, so we use constant help just for admin!
						// Show the remaining time to admin!

						@define("MS_MAINTENANCE_TEXT", ew_JsEncode($Language->Phrase("MaintenanceAdminMessage")).' '.Duration(date("Y-m-d H:i:s"), $date_end).'&nbsp;&nbsp;<a href="logout.php">'.$Language->Phrase("GoBack").'</a>', FALSE);
					}
				} else {

					// We are using this, in order to avoid the css conflict, so we use constant help just for admin!
					@define("MS_MAINTENANCE_TEXT", ew_JsEncode($Language->Phrase("MaintenanceAdminMessageUnknown")).' ', FALSE);
				}
			}
		}
	}

	// End of modification Maintenance Mode, by Masino Sinaga, May 12, 2012
}

// End of modification My_Global_Check, by Masino Sinaga, July 3, 2013
// Begin of modification How Long User Should be Allowed Login in the Messages When Failed Login Exceeds the Maximum Limit, by Masino Sinaga, May 12, 2012
function CurrentDateTime_Add_Minutes($currentdate, $minute) {
  $timestamp = strtotime("$currentdate");
  $addtime = strtotime("+$minute minutes", $timestamp);
  $next_time = date('Y/m/d H:i:s', $addtime);
  return $next_time;
}

function DurationFromSeconds($iSeconds) {

	/**
	* Convert number of seconds into years, days, hours, minutes and seconds
	* and return an string containing those values
	*
	* @param integer $seconds Number of seconds to parse
	* @return string
	*/
	global $Language;
	$y = floor($seconds / (86400*365.25));
	$d = floor(($seconds - ($y*(86400*365.25))) / 86400);
	$h = gmdate('H', $seconds);
	$m = gmdate('i', $seconds);
	$s = gmdate('s', $seconds);
	$string = '';
	if($y > 0)
		$string .= intval($y) . $Language->Phrase("years");
	if($d > 0) 
		$string .= intval($d) . $Language->Phrase("days");
	if($h > 0) 
		$string .= intval($h) . $Language->Phrase("hours");
	if($m > 0) 
		$string .= intval($m) . $Language->Phrase("minutes");
	if($s > 0) 
		$string .= intval($s) . $Language->Phrase("seconds");
	return preg_replace('/\s+/',' ',$string);
}

function Duration($parambegindate, $paramenddate) {
  global $Language;
  $begindate = strtotime($parambegindate);  
  $enddate = strtotime($paramenddate);
  $diff = intval($enddate) - intval($begindate);
  $diffday = intval(floor($diff/86400));                                      
  $modday = ($diff%86400);  
  $diffhour = intval(floor($modday/3600));  
  $diffminute = intval(floor(($modday%3600)/60));  
  $diffsecond = ($modday%60);  
  if ($diffday!=0 && $diffhour!=0 && $diffminute!=0 && $diffsecond==0) {
    return round($diffday)." ".$Language->Phrase('days').        
    ", ".round($diffhour)." ".$Language->Phrase('hours').        
    ", ".round($diffminute,0)." ".$Language->Phrase('minutes');
  } elseif ($diffday!=0 && $diffhour==0 && $diffminute!=0 && $diffsecond!=0) {
    return round($diffday)." ".$Language->Phrase('days').        
    ", ".round($diffminute)." ".$Language->Phrase('minutes').        
    ", ".round($diffsecond,0)." ".$Language->Phrase('seconds');
  } elseif ($diffday!=0 && $diffhour!=0 && $diffminute==0 && $diffsecond==0) {
    return round($diffday)." ".$Language->Phrase('days').        
    ", ".round($diffhour)." ".$Language->Phrase('hours');
  } elseif ($diffday!=0 && $diffhour==0 && $diffminute!=0 && $diffsecond==0) {
    return round($diffday)." ".$Language->Phrase('days').        
    ", ".round($diffminute,0)." ".$Language->Phrase('minutes');
  } elseif ($diffday!=0 && $diffhour==0 && $diffminute==0 && $diffsecond!=0) {
    return round($diffday)." ".$Language->Phrase('days').        
    ", ".round($diffsecond,0)." ".$Language->Phrase('seconds');	
  } elseif ($diffday!=0 && $diffhour==0 && $diffminute==0 && $diffsecond==0) {
    return round($diffday)." ".$Language->Phrase('days');
  }	elseif ($diffday==0 && $diffhour!=0 && $diffminute!=0 && $diffsecond!=0) {
    return round($diffhour)." ".$Language->Phrase('hours').",
    ".round($diffminute,0)." ".$Language->Phrase('minutes').
    ", ".round($diffsecond,0)." ".$Language->Phrase('seconds')."";
  } elseif ($diffday==0 && $diffhour!=0 && $diffminute==0 && $diffsecond==0) {
    return round($diffhour)." ".$Language->Phrase('hours');
  } elseif ($diffday==0 && $diffhour!=0 && $diffminute!=0 && $diffsecond==0) {
    return round($diffhour)." ".$Language->Phrase('hours').",
    ".round($diffminute,0)." ".$Language->Phrase('minutes');
  } elseif ($diffday==0 && $diffhour==0 && $diffminute!=0 && $diffsecond==0) {   
    return round($diffminute,0)." ".$Language->Phrase('minutes');	
  } elseif ($diffday==0 && $diffhour==0 && $diffminute!=0 && $diffsecond!=0) {   
    return round($diffminute,0)." ".$Language->Phrase('minutes').
    ", ".round($diffsecond,0)." ".$Language->Phrase('seconds')."";
  } elseif ($diffday==0 && $diffhour==0 && $diffminute==0 && $diffsecond!=0) {   
    return round($diffsecond,0)." ".$Language->Phrase('seconds')."";   
  } else {
    return round($diffday)." ".$Language->Phrase('days').        
    ", ".round($diffhour)." ".$Language->Phrase('hours').        
    ", ".round($diffminute,0)." ".$Language->Phrase('minutes').        
    ", ".round($diffsecond,0)." ".$Language->Phrase('seconds')."";
  }
}

// End of modification How Long User Should be Allowed Login in the Messages When Failed Login Exceeds the Maximum Limit, by Masino Sinaga, May 12, 2012
// Begin of modification LoadBreadcrumbLinks, by Masino Sinaga, September 22, 2014
function LoadBreadcrumbLinks($pt) {
}

// End of modification LoadBreadcrumbLinks, by Masino Sinaga, September 22, 2014
// Begin of modification Displaying Breadcrumbs in All Pages, by Masino Sinaga, May 25, 2012
function getCurrentPageTitle($pt) {
    global $CurrentPageTitle, $Language, $UserTableConn;
	if (@MS_SHOW_MASINO_BREADCRUMBLINKS == TRUE) {
		$sSql = "SELECT C.Page_Title
				FROM ".MS_MASINO_BREADCRUMBLINKS_TABLE." AS B, ".MS_MASINO_BREADCRUMBLINKS_TABLE." AS C
				WHERE (B.Lft BETWEEN C.Lft AND C.Rgt)
				AND (B.Page_URL LIKE '".$pt."')
				ORDER BY C.Lft";
		if (($rs = $UserTableConn->Execute($sSql)) && ($rs->RecordCount() > 0)) {
			$recCount = $rs->RecordCount();
			$rs->MoveFirst();
			$i = 1;
			while (!$rs->EOF) {
				if ($i < $recCount) {
				} else {

					// this is the current page, just display this, no need to display its parent!
					$CurrentPageTitle .= $Language->BreadcrumbPhrase($rs->fields("Page_Title"))."". " &laquo; " . $Language->ProjectPhrase("BodyTitle");
					return;
				}
				$i++;
				$rs->MoveNext();
			}
			$rs->Close();
		} else {
			$CurrentPageTitle = $Language->ProjectPhrase("BodyTitle");
		}
	} else {
		$CurrentPageTitle = ($Language->TablePhrase(CurrentPage()->TableName, "tblcaption") == "") ? $Language->TablePhrase(CurrentPage()->PageObjName, "tblcaption") : $Language->TablePhrase(CurrentPage()->TableName, "tblcaption");
		$CurrentPageTitle = $CurrentPageTitle . " &laquo; " . $Language->ProjectPhrase("BodyTitle");
	}
}

// End of modification Displaying Breadcrumbs in All Pages, by Masino Sinaga, May 25, 2012
// Begin of modification Check Current Active Font Name, by Masino Sinaga, February 7, 2014
function CheckActiveFontName() {
	$val = "arial"; // default
	if (IsLoggedIn()) {
		if (IsSysAdmin()) {
			$val = $_SESSION['php_stock_applicationsettings']["Font_Name"]; // ew_ExecuteScalar("SELECT Font_Name FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		} else {

			// $sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
			$val = @$_SESSION['php_stock_userpreferences']["Font_Name"]; // ew_ExecuteScalar("SELECT Font_Name FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."");	
		}
	}
	return $val;
}

// End of modification Check Current Active Font Name, by Masino Sinaga, February 7, 2014
// Begin of modification Check Current Active Font Size, by Masino Sinaga, February 7, 2014
function CheckActiveFontSize() {
	$val = "13px"; // default
	if (IsLoggedIn()) {
		if (IsSysAdmin()) {
			$val = $_SESSION['php_stock_applicationsettings']["Font_Size"]; //  ew_ExecuteScalar("SELECT Font_Size FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		} else {

			//$sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
			$val = @$_SESSION['php_stock_userpreferences']["Font_Size"]; // ew_ExecuteScalar("SELECT Font_Size FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."");	
		}
	}
	return $val;
}

// End of modification Check Current Active Font Size, by Masino Sinaga, February 7, 2014
// Begin of modification Check Current Active Theme, by Masino Sinaga, October 24, 2013
function CheckActiveTheme() {
	$val = "theme-default.css"; // default
	if (IsLoggedIn()) {
		if (IsSysAdmin()) {
			$val = $_SESSION['php_stock_applicationsettings']["Default_Theme"]; // ew_ExecuteScalar("SELECT Default_Theme FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		} else {

			// $sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
			$val = @$_SESSION['php_stock_userpreferences']["Theme"]; // ew_ExecuteScalar("SELECT Theme FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."");	
		}
	}
	return $val;
}

// End of modification Check Current Active Theme, by Masino Sinaga, October 24, 2013
// Begin of modification Check Current Active Menu Position, by Masino Sinaga, October 24, 2013
function CheckActiveMenuPosition() {
	$val = "Y"; // default
	if (IsLoggedIn()) {
		if (IsSysAdmin()) {
			$val = $_SESSION['php_stock_applicationsettings']["Menu_Horizontal"];  // ew_ExecuteScalar("SELECT Menu_Horizontal FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		} else {

			// $sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
			$val = @$_SESSION['php_stock_userpreferences']["Menu_Horizontal"];  // ew_ExecuteScalar("SELECT Menu_Horizontal FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."");	
		}
	}
	return $val;
}

// End of modification Check Current Active Menu Position, by Masino Sinaga, October 24, 2013
// Begin of modification Check Current Active Table Width Style, by Masino Sinaga, October 24, 2013
function CheckActiveTableWidthStyle() {
	$val = "1"; // default = 1 <-- Scroll
	if (IsLoggedIn()) {
		if (IsSysAdmin()) {
			$val = $_SESSION['php_stock_applicationsettings']["Table_Width_Style"]; // ew_ExecuteScalar("SELECT Table_Width_Style FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		} else {

			// $sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
			$val = @$_SESSION['php_stock_userpreferences']["Table_Width_Style"]; // ew_ExecuteScalar("SELECT Table_Width_Style FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."");	
		}
	}
	return $val;
}

// End of modification Check Current Active Table Width Style, by Masino Sinaga, October 24, 2013
// Begin of modification Check Rows Vertical Align Top, by Masino Sinaga, November 19, 2013
function CheckRowsVerticalAlignTop() {
	$val = "Y"; // default
	if (IsLoggedIn()) {
		if (IsSysAdmin()) {
			$val = $_SESSION['php_stock_applicationsettings']["Rows_Vertical_Align_Top"]; // ew_ExecuteScalar("SELECT Rows_Vertical_Align_Top FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		} else {

			// $sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
			$val = @$_SESSION['php_stock_userpreferences']["Rows_Vertical_Align_Top"]; // ew_ExecuteScalar("SELECT Rows_Vertical_Align_Top FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."");	
		}
	}
	return $val;
}

// End of modification Check Rows Vertical Align Top, by Masino Sinaga, November 19, 2013
// Begin of modification Check Font Name, by Masino Sinaga, January 13, 2014
function CheckFontName() {
	$val = "tahoma"; // default
	if (IsLoggedIn()) {
		if (IsSysAdmin()) {
			$val = $_SESSION['php_stock_applicationsettings']["Font_Name"]; // ew_ExecuteScalar("SELECT Font_Name FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		} else {
			$sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
			$val = @$_SESSION['php_stock_userpreferences']["Font_Name"]; // ew_ExecuteScalar("SELECT Font_Name FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."");	
		}
	}
	return $val;
}

// End of modification Check Font Name, by Masino Sinaga, January 13, 2014
// Begin of modification Check Font Size, by Masino Sinaga, January 13, 2014
function CheckFontSize() {
	$val = "11px"; // default
	if (IsLoggedIn()) {
		if (IsSysAdmin()) {
			$val = $_SESSION['php_stock_applicationsettings']["Font_Size"]; // ew_ExecuteScalar("SELECT Font_Size FROM ".MS_SETTINGS_TABLE." WHERE Option_Default = 'Y'");
		} else {

			// $sFilterUserName = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
			$val = @$_SESSION['php_stock_userpreferences']["Font_Size"];  // ew_ExecuteScalar("SELECT Font_Size FROM ".EW_USER_TABLE." WHERE ".$sFilterUserName."");	
		}
	}
	return $val;
}

// End of modification Check Font Name, by Masino Sinaga, January 13, 2014
function GetIntersectTwoDates($sDateCheckBegin, $sDateCheckEnd, $sLang) {
    global $UserTableConn;
	$sResult = "";
	$rs = $UserTableConn->Execute("SELECT Announcement_ID, Date_Start, Date_End
                      FROM " . MS_ANNOUNCEMENT_TABLE . " 
					  WHERE Date_Start <> '' 
					  AND Date_End <> '' 
					  AND Language = '".$sLang."'");
    if ($rs && $rs->RecordCount() > 0) {  
        while(!$rs->EOF) {
			$sDateCheckBegin = substr($sDateCheckBegin, 0, 10);
			$sDateCheckEnd = substr($sDateCheckEnd, 0, 10);
            $arrDates1 = GetAllDatesFromTwoDates($sDateCheckBegin, $sDateCheckEnd); 
			$sDateBegin = substr($rs->fields("Date_Start"), 0, 10);
			$sDateEnd = substr($rs->fields("Date_End"), 0, 10);
            $arrDates2 = GetAllDatesFromTwoDates($sDateBegin, $sDateEnd);
            $result = array_intersect($arrDates1, $arrDates2);
            foreach($result as $key => $value){ 
                $sResult .= $value.", ";
            }            
            $rs->MoveNext();
        }
        $rs->Close();
    }
    $sResult = trim($sResult, ", ");
    return $sResult;
}

function GetIntersectTwoDatesEditMode($iID, $sDateCheckBegin, $sDateCheckEnd, $sLang) {
    global $UserTableConn;
	$sResult = "";
	$rs = $UserTableConn->Execute("SELECT Announcement_ID, Date_Start, Date_End
                      FROM " . MS_ANNOUNCEMENT_TABLE . " 
					  WHERE Date_Start <> '' 
					  AND Date_End <> '' 
					  AND Announcement_ID <> ".$iID." 
					  AND Language = '".$sLang."'");
    if ($rs && $rs->RecordCount() > 0) {  
        while(!$rs->EOF) {
			$sDateCheckBegin = substr($sDateCheckBegin, 0, 10);
			$sDateCheckEnd = substr($sDateCheckEnd, 0, 10);
            $arrDates1 = GetAllDatesFromTwoDates($sDateCheckBegin, $sDateCheckEnd); 
			$sDateBegin = substr($rs->fields("Date_Start"), 0, 10);
			$sDateEnd = substr($rs->fields("Date_End"), 0, 10);
            $arrDates2 = GetAllDatesFromTwoDates($sDateBegin, $sDateEnd);
            $result = array_intersect($arrDates1, $arrDates2);
			if ( (count($result)>0) && ($rs->fields("Announcement_ID") != $iID) ) {
				$sResult .= $rs->fields("Announcement_ID")."#";
				foreach($result as $key => $value){ 
					$sResult .= $value.", ";
				} 
				$sResult = trim($sResult, ", ");
				return $sResult;
			}
            $rs->MoveNext();
        }
        $rs->Close();
    }
    return $sResult;
}

function UpdateDatesInOtherLanguage($sDateBegin, $sDateEnd, $iID) {
    global $UserTableConn;
	$sResult = "";
	$rs = $UserTableConn->Execute("UPDATE " . MS_ANNOUNCEMENT_TABLE . " 
					  SET Date_Start = '".$sDateBegin."',
					  Date_End = '".$sDateEnd."' 
					  WHERE Translated_ID = ".$iID);
    if ($rs && $rs->RecordCount() > 0) {  
        while(!$rs->EOF) {
			$sDateBegin = substr($rs->fields("Date_Start"), 0, 10);
			$sDateEnd = substr($rs->fields("Date_End"), 0, 10);
            if ( $sDateBegin != "" && $sDateEnd != "" ) {
				$sResult = $sDateBegin . "#" . $sDateEnd;
			}
            $rs->MoveNext();
        }
        $rs->Close();
    }
    return $sResult;
}

function GetAllDatesFromTwoDates($fromDate, $toDate)
{
    if(!$fromDate || !$toDate ) {return false;}
    $dateMonthYearArr = array();
    $fromDateTS = strtotime($fromDate);
    $toDateTS = strtotime($toDate);
    for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24))
    {
        $currentDateStr = date("Y-m-d",$currentDateTS);
        $dateMonthYearArr[] = $currentDateStr;
    }
    return $dateMonthYearArr;
}

function IsDateBetweenTwoDates($sDateCheckBegin, $sDateCheckEnd, $sDateBegin, $sDateEnd) {
    $dDate1 = strtotime($sDateCheckBegin);
    $dDate2 = strtotime($sDateCheckEnd);
    if ( ($dDate1 >= strtotime($sDateBegin)) && ($dDate2 <= strtotime($sDateEnd)) ) {
        return TRUE;    
    } else {
        return FALSE;    
    }  
} 
?>
