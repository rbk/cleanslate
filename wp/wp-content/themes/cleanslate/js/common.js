(function($){
	
	//transitionTime
	var guruTransTime = 350,
		maxWidth = 960;
		
	$(document).ready(function(){
		console.log('hello common ready');
		
		$('html.ie').length ? Guru.ie = true : Guru.ie = false;
		$('html.lte8').length ? Guru.lte8 = true : Guru.lte8 = false;
		typeof WebKitPoint !== 'undefined' ? Guru.webkit = true : Guru.webkit = false;

		// Browsers that support flexible box menu get the correct horizontal-nav width automatically.
		// But with IE, we have to calculate the item padding in Javascript.
		if ( $('html').hasClass('no-flexbox')) 
			autoMenu();
		
		if ($("#rotator").length)
	        new GuruRotator({
	             showControls: true
	         });
	
	});	
	
	
	function autoMenu(){

		if ( $('nav#access').length ) {

			var nav = $('nav#access'),
			btn = $('<div />', { id: 'guruMenuBtn', html: '<span>Menu</span>' }),
			lis = nav.find('li');
			lis.css({width: (nav.width() / lis.length)-1 });


			//button click handler
			var btnPress = function(e){
				console.log('btnPress', e);

				$(this).toggleClass('pressed');
				$(this).parent().find('.menu').toggle( 150 );

			};

			//attach handler to button and insert it into the dom.
			//btn.bind('mousedown mouseup', btnPress ).prependTo( nav );
			// btn.bind('click', btnPress ).prependTo( nav );

			//find the current_page item if it is a special post type archive
			lis.each(function(){				
				if ( $(this).find('a').attr('href') === window.location.href ) {
					$(this).addClass('current-menu-item current_page_item');
				}
			});
		}	


	}
	
	
})(jQuery);
