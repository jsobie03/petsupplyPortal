<?php

// Compatibility with PHP Report Maker
if (!isset($Language)) {
	include_once "ewcfg12.php";
	include_once "ewshared12.php";
	$Language = new cLanguage();
}

// Responsive layout
if (ew_IsResponsiveLayout()) {
	if (MS_SHOW_HEADER_IN_MOBILE_LAYOUT == TRUE) {
		$gsHeaderRowClass = "ewHeaderRow";
		$gsMenuColumnClass = "hidden-xs ewMenuColumn";
		$gsSiteTitleClass = "hidden-xs ewSiteTitle";
	} else {
		$gsHeaderRowClass = "hidden-xs ewHeaderRow";
		$gsMenuColumnClass = "hidden-xs ewMenuColumn";
		$gsSiteTitleClass = "hidden-xs ewSiteTitle";
	}
} else {
	$gsHeaderRowClass = "ewHeaderRow";
	$gsMenuColumnClass = "ewMenuColumn";
	$gsSiteTitleClass = "ewSiteTitle";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>
	<?php 
	global $CurrentPageTitle, $page_type;
	$sCurrentPageTitle = "";
	if ($page_type == "REPORT") {
		$sCurrentPageTitle = (getCurrentReportTitle(@ewr_CurrentPage()) != "") ? getCurrentReportTitle(@ewr_CurrentPage()) : $Language->ProjectPhrase("BodyTitle");
	} else { // default: "TABLE" in PHPMaker
		$sCurrentPageTitle = ($CurrentPageTitle != "") ? $CurrentPageTitle :  $Language->ProjectPhrase("BodyTitle");
	}
	echo $sCurrentPageTitle;
	?>
	</title>
	<?php if($Language->Phrase("dir")=="rtl") $css_prefix='-rtl.css'; else $css_prefix='.css'; ?>
<meta charset="utf-8">
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>bootstrap3/css/<?php echo ew_CssFile("bootstrap.css") ?>"> -->
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>bootstrap3/css/bootstrap-<?php echo MS_FONT_NAME; ?>-<?php echo MS_FONT_SIZE; ?><?php echo $css_prefix; ?>">
<!-- Optional theme -->
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>bootstrap3/css/<?php echo ew_CssFile("bootstrap-theme.css") ?>">
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>phpcss/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>phpcss/jquery.fileupload-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>colorbox/colorbox.css">
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<?php if (ew_IsResponsiveLayout()) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?><?php echo str_replace('.css', $css_prefix, EW_PROJECT_STYLESHEET_FILENAME); // echo ew_CssFile(EW_PROJECT_STYLESHEET_FILENAME); ?>">
<?php if (@$gsCustomExport == "pdf" && EW_PDF_STYLESHEET_FILENAME <> "") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?><?php echo EW_PDF_STYLESHEET_FILENAME ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/jquery.storageapi.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/pStrength.jquery.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/pGenerator.jquery.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/scrolltotop.js"></script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<?php ew_AddClientScript("phpjs/helpdialog.js"); // Add JavaScript ?>
<?php if($Language->Phrase("dir")=="rtl") { ?>
<?php ew_AddStylesheet("alertifyjs/css/alertify.rtl.min.css"); // Add CSS stylesheet ?>
<?php ew_AddStylesheet("alertifyjs/css/themes/bootstrap.rtl.min.css"); // Add CSS stylesheet ?>
<?php } else { ?>
<?php ew_AddStylesheet("alertifyjs/css/alertify.min.css"); // Add CSS stylesheet ?>
<?php ew_AddStylesheet("alertifyjs/css/themes/bootstrap.min.css"); // Add CSS stylesheet ?>
<?php } ?>
<?php ew_AddClientScript("alertifyjs/alertify.min.js"); // Add JavaScript ?>
<?php ew_AddStylesheet("bootstrap3/css/bootstrap-modal.css"); // Add CSS stylesheet ?>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>bootstrap3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/typeahead.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jqueryfileupload/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jqueryfileupload/load-image.all.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jqueryfileupload/jqueryfileupload.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/mobile-detect.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/moment.min.js"></script>
<style>
</style>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/autonumeric.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/eweditor.js"></script>
<link href="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/ewcalendar.js"></script>
<script type="text/javascript">
var EW_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EW_DATE_SEPARATOR = "/"; // Default date separator
var EW_DEFAULT_DATE_FORMAT = "<?php echo EW_DEFAULT_DATE_FORMAT ?>"; // Default date format
var EW_DECIMAL_POINT = "<?php echo $DEFAULT_DECIMAL_POINT ?>";
var EW_THOUSANDS_SEP = "<?php echo $DEFAULT_THOUSANDS_SEP ?>";
var EW_MIN_PASSWORD_STRENGTH = 60;
var EW_GENERATE_PASSWORD_LENGTH = 16;
var EW_GENERATE_PASSWORD_UPPERCASE = true;
var EW_GENERATE_PASSWORD_LOWERCASE = true;
var EW_GENERATE_PASSWORD_NUMBER = true;
var EW_GENERATE_PASSWORD_SPECIALCHARS = false;
var EW_SESSION_TIMEOUT = <?php echo (EW_SESSION_TIMEOUT > 0) ? ew_SessionTimeoutTime() : 0 ?>; // Session timeout time (seconds)
var EW_SESSION_TIMEOUT_COUNTDOWN = <?php echo EW_SESSION_TIMEOUT_COUNTDOWN ?>; // Count down time to session timeout (seconds)
var EW_SESSION_KEEP_ALIVE_INTERVAL = <?php echo EW_SESSION_KEEP_ALIVE_INTERVAL ?>; // Keep alive interval (seconds)
var EW_RELATIVE_PATH = "<?php echo $EW_RELATIVE_PATH ?>"; // Relative path
var EW_SESSION_URL = EW_RELATIVE_PATH + "ewsession12.php"; // Session URL
var EW_IS_LOGGEDIN = <?php echo IsLoggedIn() ? "true" : "false" ?>; // Is logged in
var EW_IS_AUTOLOGIN = <?php echo IsAutoLogin() ? "true" : "false" ?>; // Is logged in with option "Auto login until I logout explicitly"
var EW_LOGOUT_URL = EW_RELATIVE_PATH + "logout.php"; // Logout URL
var EW_LOOKUP_FILE_NAME = "ewlookup12.php"; // Lookup file name
var EW_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EW_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries
var EW_MAX_EMAIL_RECIPIENT = <?php echo EW_MAX_EMAIL_RECIPIENT ?>;
var EW_DISABLE_BUTTON_ON_SUBMIT = true;
var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
var EW_UPLOAD_URL = "<?php echo EW_UPLOAD_URL ?>"; // Upload URL
var EW_UPLOAD_THUMBNAIL_WIDTH = <?php echo EW_UPLOAD_THUMBNAIL_WIDTH ?>; // Upload thumbnail width
var EW_UPLOAD_THUMBNAIL_HEIGHT = <?php echo EW_UPLOAD_THUMBNAIL_HEIGHT ?>; // Upload thumbnail height
var EW_MULTIPLE_UPLOAD_SEPARATOR = "<?php echo EW_MULTIPLE_UPLOAD_SEPARATOR ?>"; // Upload multiple separator
var EW_USE_COLORBOX = <?php echo (EW_USE_COLORBOX) ? "true" : "false" ?>;
var EW_USE_JAVASCRIPT_MESSAGE = <?php echo MS_USE_JAVASCRIPT_MESSAGE ?>; // old method: --> get from PHPMaker project setting --> true;
var EW_MOBILE_DETECT = new MobileDetect(window.navigator.userAgent);
var EW_IS_MOBILE = EW_MOBILE_DETECT.mobile() ? true : false;
var EW_PROJECT_STYLESHEET_FILENAME = "<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>"; // Project style sheet
var EW_PDF_STYLESHEET_FILENAME = "<?php echo EW_PDF_STYLESHEET_FILENAME ?>"; // Pdf style sheet
var EW_TOKEN = "<?php echo @$gsToken ?>";

// var EW_CSS_FLIP = <?php echo (EW_CSS_FLIP) ? "true" : "false" ?>;
var EW_CSS_FLIP = <?php echo ($Language->Phrase("dir")=="rtl") ? "true" : "false" ?>;
var EW_CONFIRM_CANCEL = true;
</script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/jsrender.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/ewp12.js"></script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript">
var ewVar = <?php echo json_encode($EW_CLIENT_VAR); ?>;
<?php echo $Language->ToJSON() ?>
</script>
<?php 
if (MS_ENABLE_VISITOR_STATS == TRUE) {
	include "visitorstatistics.php";
}
?>
<script type="text/javascript">

function createCookie(name, value, days) { if (days) { var date = new Date(); date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); var expires = "; expires=" + date.toGMTString(); } else var expires = ""; document.cookie = name + "=" + value + expires + "; path=/"; }

function getCookie(c_name) { if (document.cookie.length > 0) { c_start = document.cookie.indexOf(c_name + "="); if (c_start != -1) { c_start = c_start + c_name.length + 1; c_end = document.cookie.indexOf(";", c_start); if (c_end == -1) { c_end = document.cookie.length; } return unescape(document.cookie.substring(c_start, c_end)); } } return ""; }
</script>
<?php if (MS_USE_TABLE_SETTING_FOR_SEARCH_PANEL_STATUS==FALSE && MS_USE_PHPMAKER_SETTING_FOR_INITIATE_SEARCH_PANEL==FALSE) { ?>
<?php ew_AddClientScript("phpjs/searchpanelstatus.js");  ?>
<?php } ?>
<script type="text/javascript">
paceOptions = {
  ajax: false, // disabled
  document: false, // disabled
  eventLag: false, // disabled
  restartOnPushState: false,
  elements: {
    selectors: ['#ewTooltip']
  }
};
</script>
<?php ew_AddClientScript("loading/pace.min.js"); // Add JavaScript ?>
<?php ew_AddStylesheet("loading/themes/".MS_LOADING_THEME.""); // Add CSS stylesheet ?>
<script type="text/javascript">

// jQuery for auto hide message after 3 seconds, by Masino Sinaga, October 18, 2011
$(document).ready(function() {
	$("p#ewSuccessMessage").show().delay(3000).queue(function(n) {$(this).hide('slow'); n();}); 
});
</script>
<script type="text/javascript">
alertify.defaults.pinnable = true;
<?php if (MS_ALERTIFY_DIALOG_STYLE == "modal") { ?>
alertify.defaults.modal = true;
<?php } else { ?>
alertify.defaults.modal = false;
<?php } ?>
alertify.defaults.transition = "<?php echo MS_ALERTIFY_TRANSITION_STYLE; ?>";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";

function AskToLogout() {
	alertify.confirm("<?php echo $Language->Phrase('AskToLogout'); ?>",function(e){if(e){alertify.success("<?php echo $Language->Phrase('AlertifyProcessing'); ?>"); document.location.href = 'logout.php';}}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}).set('defaultFocus', 'cancel').set('title', 'Logout');
}
</script>
<?php
if (MS_DETECT_CHANGES_ON_ADD_FORM) {
  if (CurrentPageID() == "add") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
if (MS_DETECT_CHANGES_ON_EDIT_FORM) {
  if (CurrentPageID() == "edit" || CurrentPageID() == "update") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
if (MS_DETECT_CHANGES_ON_SEARCH_FORM) {
  if (CurrentPageID() == "search") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
if (MS_DETECT_CHANGES_ON_LIST_FORM) {
  if (CurrentPageID() == "list" || CurrentPageID() == "grid") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
if (MS_DETECT_CHANGES_ON_USERPRIV_FORM) {
  if (ew_CurrentPage() == "userpriv.php") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
if (MS_DETECT_CHANGES_ON_LOGIN_FORM) {
  if (ew_CurrentPage() == "login.php") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
if (MS_DETECT_CHANGES_ON_REGISTRATION_FORM) {
  if (ew_CurrentPage() == "register.php") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
if (MS_DETECT_CHANGES_ON_FORGOTPASSWORD_FORM) {
  if (ew_CurrentPage() == "forgotpwd.php") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
if (MS_DETECT_CHANGES_ON_CHANGEPASSWORD_FORM) {
  if (ew_CurrentPage() == "changepwd.php") {
    ew_AddClientScript("phpjs/detectchanges.js"); // Add JavaScript
  }
}
?>
<?php $sCustomCSS = str_replace('.css', $css_prefix, 'phpcss/customcss-'.MS_FONT_SIZE.'.css'); ?>
<?php ew_AddStylesheet($sCustomCSS); // Custom CSS ?>
<style>
<?php if (MS_TABLE_WIDTH_STYLE == "1") { ?>
html { height: auto; width: <?php echo (MS_TOTAL_WIDTH); ?>px; display: block; margin-left: auto; margin-right: auto; margin-top: 0px; padding-bottom: 0px;}
<?php if (MS_SHOW_BORDER_LAYOUT) { ?>
body { background-color: inherit; border-left: 1px solid #DEDEDE; border-right: 1px solid #DEDEDE; border-top: 1px solid #DEDEDE; border-bottom: 1px solid #DEDEDE; color: inherit; margin: 0; width: <?php echo (MS_TOTAL_WIDTH); ?>px; height: auto; display: block;}
<?php } else { ?>
body { background-color: inherit; color: inherit; margin: 0; width: <?php echo (MS_TOTAL_WIDTH); ?>px; height: auto; display: block;}
<?php } ?>
<?php if (MS_SHOW_SHADOW_LAYOUT) { ?>
.ewLayout { width: <?php echo (MS_TOTAL_WIDTH); ?>px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px -moz-box-shadow: 8px 7px 8px #888; -webkit-box-shadow: 8px 7px 8px #888; box-shadow: 8px 7px 8px #888;}
<?php } else { ?>
.ewLayout { width: <?php echo (MS_TOTAL_WIDTH); ?>px; }
<?php } ?>
.ewContentTable { width: <?php echo (MS_TOTAL_WIDTH); ?>px; height: 100%; clear: left;}
.ewMenuColumn { width: <?php echo MS_VERTICAL_MENU_WIDTH; ?>px;}
<?php } elseif (MS_TABLE_WIDTH_STYLE == "2") { ?>
html { height: auto; width: auto; display: block; margin-left: auto; margin-right: auto; margin-top: 0px; padding-bottom: 0px;}
.navbar { min-width: 310px; }
<?php if (MS_SHOW_BORDER_LAYOUT) { ?>
body { background-color: inherit; border-left: 1px solid #DEDEDE; border-right: 1px solid #DEDEDE; border-top: 1px solid #DEDEDE; border-bottom: 1px solid #DEDEDE; color: inherit; margin: 0; width: auto; height: auto; display: block;}
<?php } else { ?>
body { background-color: inherit; color: inherit; margin: 0; width: auto; height: auto; display: block;}
<?php } ?>
<?php if (MS_SHOW_SHADOW_LAYOUT) { ?>
.ewLayout { width: auto; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px -moz-box-shadow: 8px 7px 8px #888; -webkit-box-shadow: 8px 7px 8px #888; box-shadow: 8px 7px 8px #888;}
<?php } else { ?>
.ewLayout { width: auto; }
<?php } ?>
.ewContentTable { width: 100%; height: 100%; clear: left;}
.ewMenuColumn { width: <?php echo MS_VERTICAL_MENU_WIDTH; ?>px;}
<?php } elseif (MS_TABLE_WIDTH_STYLE == "3") { ?>
html { height: auto; width: 100%; display: block; margin-left: auto; margin-right: auto; margin-top: 0px; padding-bottom: 0px;}
.navbar { min-width: 310px; }
<?php if (MS_SHOW_BORDER_LAYOUT) { ?>
body { background-color: inherit; border-left: 1px solid #DEDEDE; border-right: 1px solid #DEDEDE; border-top: 1px solid #DEDEDE; border-bottom: 1px solid #DEDEDE; color: inherit; margin: 0; width: 100%; height: auto; display: block;}
<?php } else { ?>
body { background-color: inherit; color: inherit; margin: 0; width: 100%; height: auto; display: block;}
<?php } ?>
<?php if (MS_SHOW_SHADOW_LAYOUT) { ?>
.ewLayout { width: 100%; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px -moz-box-shadow: 8px 7px 8px #888; -webkit-box-shadow: 8px 7px 8px #888; box-shadow: 8px 7px 8px #888;}
<?php } else { ?>
.ewLayout { width: 100%; }
<?php } ?>
.ewContentTable { width: 99%; height: 100%; clear: left;}
.ewMenuColumn { width: <?php echo MS_VERTICAL_MENU_WIDTH; ?>px;}
<?php } ?>
.ewHeaderRow{line-height:10px;}
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS == TRUE || MS_SHOW_MASINO_BREADCRUMBLINKS == TRUE) { ?>
.breadcrumb > li + li:before {content: "/\00a0"; padding: 0 5px; color: #cccccc; }
.breadcrumb > li > .divider {padding:0; color:#ccc;}
<?php define("MS_BREADCRUMBLINKS_DIVIDER", "", FALSE); ?>
<?php } elseif (MS_SHOW_PHPMAKER_BREADCRUMBLINKS == FALSE && MS_SHOW_MASINO_BREADCRUMBLINKS == TRUE) {?>
.breadcrumb > li + li:before { content: ""; padding: 0; color: #cccccc;}
<?php } ?>
<?php if (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-black.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #c0c0c0; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #d1d1d1; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-blue.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #edf5ff; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #ffffff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-dark.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #dcdcdc; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #eeeeee; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-darkglass.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #ededeb; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #f9f9f9; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-default.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #dcdcdc; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #f5f5f5; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-glass.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #f3f8f7; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #ffffff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-gray.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #dcdcdc; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #f5f5f5; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-green.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #eef4e0; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #ffffff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-maroon.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #fffbd6; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #ffffff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-olive.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #f1fed8; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #ffffff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-professional.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #f7f6f3; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #ffffff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-purple.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #f7f7f7; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #e7e7ff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-red.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #f8edef; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #ffffff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-sand.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #eee8aa; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #fafad2; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-silver.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #ededeb; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #ffffff; margin-left:3px; margin-right:3px;}
<?php } elseif (EW_PROJECT_STYLESHEET_FILENAME == "phpcss/theme-white.css") { ?>
.ewEditForm>div>div.form-group:nth-child(odd), .ewAddForm>div>div.form-group:nth-child(odd), .ewSearchForm>div>div.form-group:nth-child(odd), .ewUpdateForm>div>div.form-group:nth-child(odd) { margin-bottom: 6px; background-color: #ededeb; margin-left:3px; margin-right:3px;}
.ewEditForm>div>div.form-group:nth-child(even), .ewAddForm>div>div.form-group:nth-child(even), .ewSearchForm>div>div.form-group:nth-child(even), .ewUpdateForm>div>div.form-group:nth-child(even) { margin-bottom: 6px; background-color: #f9f9f9; margin-left:3px; margin-right:3px;}
<?php } // EW_PROJECT_SYTLESHEET_FILENAME ?>
</style>
<script type="text/javascript">
var MS_TOOLTIP_POSITION_FOR_INPUT_ELEMENT = "Bottom";
</script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/userfn12.js"></script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<style>
.MasinoHeaderRow:after,.MasinoHeaderRow:before{display:table;content:"";clear:both;}
<?php if (MS_STICKY_MENU_ON_SCROLLING==TRUE) { ?>
<?php if (MS_TABLE_WIDTH_STYLE <> 1) { ?>
.StickyToTop{position:fixed;top:0;width:100%;z-index:10000;}
<?php } else { ?>
.StickyToTop{position:fixed;top:0;width:<?php echo (MS_SCROLL_TABLE_WIDTH + 40).'px'; ?>;z-index:10000;}
<?php } ?>
<?php } ?>
<?php if (MS_STICKY_FOOTER==TRUE && MS_TABLE_WIDTH_STYLE <> "1") { ?>
.ewLayout { margin-bottom: 80px;}
.ewFooterRow { position: fixed; width: 100%; bottom:0; z-index: 999;}
<?php } elseif (MS_STICKY_FOOTER==TRUE && MS_TABLE_WIDTH_STYLE == "1") { ?>
.ewLayout { margin-bottom: 80px;}
.ewFooterRow { position: fixed; width: <?php echo (MS_TOTAL_WIDTH)."px"; ?>; bottom:0; z-index: 999;}
<?php } ?>
</style>
<meta name="generator" content="PHPMaker v12.0.3">
</head>
<body dir="<?php echo $Language->Phrase("dir"); ?>">
<?php // Begin of modification Announcement in All Pages, by Masino Sinaga, May 12, 2012 ?>
<?php if (MS_SHOW_ANNOUNCEMENT==TRUE) { ?>
<?php   if (MS_ANNOUNCEMENT_TEXT!="") { ?>
<div class="box-announcement alert-info"><?php echo MS_ANNOUNCEMENT_TEXT; ?></div>
<?php   } ?>
<?php } ?>
<?php // End of modification Announcement in All Pages, by Masino Sinaga, May 12, 2012 ?>
<?php // Begin of modification Maintenance Mode, by Masino Sinaga, May 12, 2012 ?>
<?php $date_now = date("Y-m-d H:i:s"); ?>
<?php if ( (MS_MAINTENANCE_MODE==TRUE) &&
           (strtotime(MS_MAINTENANCE_END_DATETIME) < strtotime($date_now)) &&
           (MS_AUTO_NORMAL_AFTER_MAINTENANCE==FALSE) ||
           (MS_MAINTENANCE_MODE==TRUE) &&
           (strtotime(MS_MAINTENANCE_END_DATETIME) > strtotime($date_now)) &&
           (MS_AUTO_NORMAL_AFTER_MAINTENANCE==TRUE) ||
           (MS_MAINTENANCE_MODE==TRUE) &&
           (MS_MAINTENANCE_END_DATETIME=="") ) { ?>
<?php   if (MS_MAINTENANCE_TEXT!="") { ?>
<div class="box-maintenance alert-danger"><?php echo MS_MAINTENANCE_TEXT; ?></div>
<?php   } ?>
<?php } ?>
<?php // End of modification Maintenance Mode, by Masino Sinaga, May 12, 2012 ?>
<?php if (@!$gbSkipHeaderFooter) { ?>
<?php if (@$gsExport == "") { ?>
<div class="ewLayout">
	<?php if (MS_SHOW_ENTIRE_HEADER == TRUE) { ?>
	<!-- header (begin) --><!-- ** Note: Only licensed users are allowed to change the logo ** -->
	<div id="ewHeaderRow" class="MasinoHeaderRow <?php echo $gsHeaderRowClass ?>">
		<?php if (MS_SHOW_LOGO_IN_HEADER) { ?>
		<?php if (MS_SHOW_LOGO_IN_MOBILE_LAYOUT) { ?>
		<?php if (MS_LOGO_IMAGE_IN_MOBILE_LAYOUT != "") { ?>
		<div class="hidden-lg hidden-md hidden-sm <?php echo MS_HEADER_LOGO_CLASS; ?>" <?php if($Language->Phrase("dir")=="rtl") { ?> style="float: right;" <?php } else { ?> style="float: left;" <?php } ?>>
			<div><a href="." title="<?php echo $Language->ProjectPhrase("BodyTitle"); ?>"><img src="<?php echo $EW_RELATIVE_PATH ?><?php echo MS_LOGO_IMAGE_IN_MOBILE_LAYOUT; ?>" alt="<?php echo $Language->ProjectPhrase("BodyTitle"); ?>"></a></div>
		</div>
		<?php } ?>
		<div class="hidden-xs <?php echo MS_HEADER_LOGO_CLASS; ?>" <?php if($Language->Phrase("dir")=="rtl") { ?> style="float: right;" <?php } else { ?> style="float: left;" <?php } ?>>
			<div><a href="." title="<?php echo $Language->ProjectPhrase("BodyTitle"); ?>"><img src="<?php echo $EW_RELATIVE_PATH ?>phpimages/stock_inventory_management_logo_transparant.png" alt=""></a></div>
		</div>
		<?php } else { ?>
		<div class="hidden-xs <?php echo MS_HEADER_LOGO_CLASS; ?>" <?php if($Language->Phrase("dir")=="rtl") { ?> style="float: right;" <?php } else { ?> style="float: left;" <?php } ?>>
			<div><a href="." title="<?php echo $Language->ProjectPhrase("BodyTitle"); ?>"><img src="<?php echo $EW_RELATIVE_PATH ?>phpimages/stock_inventory_management_logo_transparant.png" alt=""></a></div>
		</div>
		<?php if (MS_LOGO_IMAGE_IN_MOBILE_LAYOUT != "") { ?>
		<div class="hidden-xs hidden-lg hidden-md hidden-sm <?php echo MS_HEADER_LOGO_CLASS; ?>" <?php if($Language->Phrase("dir")=="rtl") { ?> style="float: right;" <?php } else { ?> style="float: left;" <?php } ?>>
			<div><a href="." title="<?php echo $Language->ProjectPhrase("BodyTitle"); ?>"><img src="<?php echo $EW_RELATIVE_PATH ?><?php echo MS_LOGO_IMAGE_IN_MOBILE_LAYOUT; ?>" alt="<?php echo $Language->ProjectPhrase("BodyTitle"); ?>"></a></div>
		</div>
		<?php } ?>
		<?php } ?>
		<?php } ?>
		<?php if (MS_SHOW_SITE_TITLE_IN_HEADER) { ?>
		<div class="<?php echo MS_HEADER_TEXT_CLASS; ?>" style="height: 30px;">
			<?php if (MS_TEXT_ALIGN_IN_HEADER == "left") { ?>
			  <div class="ewHeaderRow pull-left" style="padding-top: 8px; padding-bottom: 4px;"><strong><span style="font-family:<?php echo MS_SITE_TITLE_FONT_NAME ?>;font-size:<?php echo MS_SITE_TITLE_FONT_SIZE; ?>;color:white;text-transform:<?php echo MS_SITE_TITLE_TEXT_STYLE; ?>"><?php echo $Language->ProjectPhrase("BodyTitle") ?>&nbsp;&nbsp;</span></strong></div><br>
			<?php } elseif (MS_TEXT_ALIGN_IN_HEADER == "right") { ?>
			  <div class="ewHeaderRow pull-right" style="padding-top: 8px; padding-bottom: 4px;"><strong><span style="font-family:<?php echo MS_SITE_TITLE_FONT_NAME ?>;font-size:<?php echo MS_SITE_TITLE_FONT_SIZE; ?>;color:white;text-transform:<?php echo MS_SITE_TITLE_TEXT_STYLE; ?>"><?php echo $Language->ProjectPhrase("BodyTitle") ?>&nbsp;&nbsp;</span></strong></div><br>
			<?php } else { ?>
			  <div align="center" style="padding-top: 8px; padding-bottom: 4px;"><strong><span style="font-family:<?php echo MS_SITE_TITLE_FONT_NAME ?>;font-size:<?php echo MS_SITE_TITLE_FONT_SIZE; ?>;color:white;text-transform:<?php echo MS_SITE_TITLE_TEXT_STYLE; ?>"><?php echo $Language->ProjectPhrase("BodyTitle") ?>&nbsp;&nbsp;</span></strong></div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php if (MS_SHOW_CURRENT_USER_IN_HEADER) { ?>
		<div class="<?php echo MS_HEADER_TEXT_CLASS; ?>" style="height: 20px;">
				<?php if (MS_TEXT_ALIGN_IN_HEADER == "left") { ?>
				  <div class="ewHeaderRow pull-left" id="msUserName" style="padding-top: 8px; padding-bottom: 4px;"><font color="white"><?php if ($Security->IsLoggedIn()=="login") { echo "". $Language->Phrase("UserName").": <strong>" . $Security->CurrentUserName() . "</strong> | <a id=\"logout\" href=\"javascript:void(0);\" onclick=\"AskToLogout();return false;\">Logout</a>"; } ?></font></div><br>
				<?php } elseif (MS_TEXT_ALIGN_IN_HEADER == "right") { ?>
				  <div class="ewHeaderRow pull-right" id="msUserName" style="padding-top: 8px; padding-bottom: 4px;"><font color="white"><?php if ($Security->IsLoggedIn()=="login") { echo "". $Language->Phrase("UserName").": <strong>" . $Security->CurrentUserName() . "</strong> | <a id=\"logout\" href=\"javascript:void(0);\" onclick=\"AskToLogout();return false;\">Logout</a>"; } ?></font></div><br>
				<?php } else { ?>
				  <div align="center" id="msUserName" style="padding-top: 8px; padding-bottom: 4px;"><strong><font color="white"><?php if ($Security->IsLoggedIn()=="login") { echo "". $Language->Phrase("UserName").": <strong>" . $Security->CurrentUserName() . "</strong> | <a id=\"logout\" href=\"javascript:void(0);\" onclick=\"AskToLogout();return false;\">Logout</a>"; } ?></font></strong></div>
				<?php } ?>
		</div>
		<?php } ?>
		<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="inheader") { ?>		
		<?php if (ew_IsResponsiveLayout()) { ?> 
		<div class="<?php echo MS_HEADER_TEXT_CLASS; ?> hidden-xs container" style="height: 38px;">
		<?php } else { ?>
		<div class="<?php echo MS_HEADER_TEXT_CLASS; ?> container" style="height: 38px;">
		<?php } ?>
			<?php if (MS_LANGUAGE_SELECTOR_ALIGN=="autoadjust") { ?>
			<?php if (MS_TEXT_ALIGN_IN_HEADER == "left") { ?>
					<div class="ewLanguageOption" style="padding-top: 4px; text-align: left; color: white;">
			<?php } elseif (MS_TEXT_ALIGN_IN_HEADER == "right") { ?>
					<div class="ewLanguageOption" style="padding-top: 4px; text-align: right; color: white;">
			<?php } else { ?>
					<div class="ewLanguageOption" style="padding-top: 4px; text-align: center; color: white;">
			<?php } ?>
			<?php } elseif (MS_LANGUAGE_SELECTOR_ALIGN=="left") { ?>
					<div class="ewLanguageOption" style="padding-top: 4px; text-align: left; color: white;">
			<?php } elseif (MS_LANGUAGE_SELECTOR_ALIGN=="right") { ?>
					<div class="ewLanguageOption" style="padding-top: 4px; text-align: right; color: white;">
			<?php } else { ?>
					<div class="ewLanguageOption" style="padding-top: 4px; text-align: center; color: white;">
			<?php } ?>
						<form class="ewForm"><?php echo $Language->Phrase("Language") ?>
						<select class="form-control" id="ewLanguage" name="ewLanguage" onchange="ew_SetLanguage(this);">
						<?php foreach ($EW_LANGUAGE_FILE as $langfile) { ?>
						<option value="<?php echo $langfile[0] ?>"<?php if ($gsLanguage == $langfile[0]) echo " selected=\"selected\"" ?>><?php echo $langfile[1] ?></option>
						<?php } ?>
						</select>
						</form>
					</div>
		</div>
		<?php } ?>
	</div>	
	<?php } ?>
<?php if (ew_IsResponsiveLayout()) { ?>
<nav id="ewMobileMenu" role="navigation" class="navbar navbar-default visible-xs hidden-print">
	<div class="container-fluid"><!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button data-target="#ewMenu" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo (EW_MENUBAR_BRAND_HYPERLINK <> "") ? EW_MENUBAR_BRAND_HYPERLINK : "javascript:void(0);" ?>"><?php echo (EW_MENUBAR_BRAND <> "") ? EW_MENUBAR_BRAND : $Language->ProjectPhrase("BodyTitle") ?></a>
					<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="inheader") { ?>
					<div class="clearfix"></div>
					<div class="col-sm-12">
						<form class="form-horizontal ewForm">
						<select class="form-control" id="ewLanguage" name="ewLanguage" onchange="ew_SetLanguage(this);">
						<?php foreach ($EW_LANGUAGE_FILE as $langfile) { ?>
						<option value="<?php echo $langfile[0] ?>"<?php if ($gsLanguage == $langfile[0]) echo " selected=\"selected\"" ?>><?php echo $langfile[1] ?></option>
						<?php } ?>
						</select>
						</form>
					</div>
					<?php } ?>
		</div>
		<div id="ewMenu" class="collapse navbar-collapse" style="height: auto;"><!-- Begin Main Menu -->
<?php
	$RootMenu = new cMenu("MobileMenu");
	$RootMenu->MenuBarClassName = "";
	$RootMenu->MenuClassName = "nav navbar-nav";
	$RootMenu->SubMenuClassName = "dropdown-menu";
	$RootMenu->SubMenuDropdownImage = "";
	$RootMenu->SubMenuDropdownIconClassName = "icon-arrow-down";
	$RootMenu->MenuDividerClassName = "divider";
	$RootMenu->MenuItemClassName = "dropdown";
	$RootMenu->SubMenuItemClassName = "dropdown";
	$RootMenu->MenuActiveItemClassName = "active";
	$RootMenu->SubMenuActiveItemClassName = "active";
	$RootMenu->MenuRootGroupTitleAsSubMenu = TRUE;
	$RootMenu->MenuLinkDropdownClass = "ewDropdown";
	$RootMenu->MenuLinkClassName = "icon-arrow-right";
?>
<?php include_once "ewmobilemenu.php" ?>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<?php } ?>
	<!-- header (end) -->
<?php if (MS_MENU_HORIZONTAL) { // Begin of modification Supports for Horizontal and Vertical Menu, by Masino Sinaga, April 30, 2012 ?>
	<div id="ewMenuRow"<?php if (ew_IsResponsiveLayout()) { ?> class="hidden-xs"<?php } ?>>
		<div class="ewMenu">
<?php include_once "ewmenu.php" ?>
		</div>
	</div>
	<!-- content (begin) -->
	<div id="ewContentTable" class="ewContentTable">
		<div id="ewContentRow">
<?php } else { // Masino Sinaga ?>
	<!-- content (begin) -->
	<div id="ewContentTable" class="ewContentTable">
		<div id="ewContentRow">
			<div id="ewMenuColumn" class="<?php echo $gsMenuColumnClass ?>">
				<!-- left column (begin) -->
				<div class="ewMenu">
<?php include_once "ewmenu.php" ?>
				</div>
				<!-- left column (end) -->
			</div>
<?php } // Masino Sinaga ?>
			<div id="ewContentColumn" class="ewContentColumn">
				<!-- right column (begin) -->
				<?php if (MS_SHOW_APP_TITLE_INSIDE_BODY == TRUE) { ?>
				<h4 class="<?php echo $gsSiteTitleClass ?>"><?php echo $Language->ProjectPhrase("BodyTitle") ?></h4>
				<?php } ?>
<?php } ?>
<?php } ?>
