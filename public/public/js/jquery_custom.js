/*
	Project Name : Directory Listing HTML
	Author Company : Viaviwebtech	
	Author Website : http://www.viaviweb.com	
*/

$(window).load(function(){
    $('#vfx_loader_block').fadeOut("slow");
});

(function($) {
/************** vfx coutter item ***************/
if($(".vfx-coutter-item").length > 0)
{
	$('.vfx-coutter-item').counterUp({
		delay:30,
		time:1800
	});
}		
})(jQuery);