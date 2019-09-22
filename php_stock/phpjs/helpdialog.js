var msHelpDialog;
var msAboutDialog;
var msTACDialog;

function msHelpDialogShow() {
	var $ = jQuery, $dlg = msHelpDialog || $("#msHelpDialog")
	if (!$dlg)
		return;
	msHelpDialog = $dlg.modal("show");
}

function msAboutDialogShow() {
	var $ = jQuery, $dlg = msAboutDialog || $("#msAboutDialog")
	if (!$dlg)
		return;
	msAboutDialog = $dlg.modal("show");
}

function msTACDialogShow() {
	var $ = jQuery, $dlg = msTACDialog || $("#msTACDialog")
	if (!$dlg)
		return;
	msTACDialog = $dlg.modal("show");
}

/* center modal */
function centerModals(){
  $('.modal').each(function(i){
    var $clone = $(this).clone().css('display', 'block').appendTo('body');
    var top = ($clone.height() - $clone.find('.modal-content').height()) / 2;
    top = top > 0 ? top : 0;
    $clone.remove();
    $(this).find('.modal-content').css("margin-top", top);
  });
}
$('.modal').on('show.bs.modal', centerModals);
$(window).on('resize', centerModals);
