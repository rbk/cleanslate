(function($){
	
	//transitionTime
	var guruTransTime = 350,
		maxWidth = 960;
		
	$(document).ready(function(){
		
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
	
        if( $('#gMap').length ){
                new Guru.Map({
                        streetViewControl: false,
                        fitMarkers: false,
                        zoom: 15,
                        centerLat: 36.1503681,
                        centerLng: -95.9897992,
                        mapHeight: 284,
                        contId: 'gMap',
                        dataCont: '.locationList', //specify the container id so it doesn't pick up all the location lists around the page
                        locationKey: 'address',
                        markerScale: 0.4,
                        markerOverridesCenter: true,
                        //markerImageKey: 'featured_custom_marker',
                        blocksAreClickable: true,
                        scrollToMapOnClick: true,
                        scrollSpeed: 450,
                        directionsLink: true,
                        globalInitId: 'gMapInit'
                });
			}

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
