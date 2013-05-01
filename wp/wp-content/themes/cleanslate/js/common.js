(function($){
		
	$(document).ready(function(){
		console.log('hello common ready');
		
		$('html.ie').length ? Guru.ie = true : Guru.ie = false;
		$('html.lte8').length ? Guru.lte8 = true : Guru.lte8 = false;
		typeof WebKitPoint !== 'undefined' ? Guru.webkit = true : Guru.webkit = false;
		
		$(".access .menu").addClass('up');
		
		$(".access .mobile-menu").click( function(e){
			
			$(this).parents('nav').find('.menu').toggleClass('down', 'up');
			
			e.preventDefault();
		});		
	});
	
})(jQuery);
