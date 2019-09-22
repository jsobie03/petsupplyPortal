$(document).ready(function(){
    $("form.ewForm :input").change(function() {
        var fObj = $(this).closest('form');
        if(!fObj.data('changed')){
            fObj.data('changed', true);
            $('button[type=submit]', fObj).css('color', 'red');
			$(window).bind('beforeunload', function(closeIt) {
				return "Are you sure?";
			});
        }
    });
    $("form.ewForm :input[type=reset]").click(function() {
        var fObj = $(this).closest('form');
        if(fObj.data('changed')){
            $('button[type=submit]', fObj).removeAttr('style');
            $('label', fObj).removeAttr('style');
            fObj.data('changed', false);
            $(window).unbind('beforeunload');
        }
    });
	$("#btnCancel").click(function() {
        var fObj = $(this).closest('form');
        if(fObj.data('changed')){
            $('button[type=submit]', fObj).removeAttr('style');
            $('label', fObj).removeAttr('style');
            fObj.data('changed', false);
            $(window).unbind('beforeunload');
        }
    });
    $('form.ewForm').submit(function() {
        var fObj = $(this).closest('form');
        if(fObj.data('changed')){
            $('button[type=submit]', fObj).removeAttr('style');
            $('label', fObj).removeAttr('style');
            fObj.data('changed', false);
            $(window).unbind('beforeunload');
        }
    });
});
