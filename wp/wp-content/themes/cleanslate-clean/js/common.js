/*
 *
 * Add custom javascript.
 * Don't get too crazy and use comments.
 * 
 *
*/
jQuery(document).ready(function($){
	
	// equalWidthTopNavItems();

});

function equalWidthTopNavItems(){
	// Have the top nav links resize to fit the screen all the time. 
	var menu_items = $('nav.access li');
	var menu_count = menu_items.length;
	menu_items.css({'width': (100 / menu_count) + '%' });
}



// jQuery plugin for google maps, modifiy options as needed
(function( $ ) {

	// 	Example :
  // Markup: <div class="map"></div>
  // JS
	// 			$('#map').googleMap({
	// 				'address' : 'south padre island, tx',
	// 				'zoom' : 15	
	// 			});

	$.fn.googleMap = function(options) {

		var settings = $.extend( {
			'id' 		: $(this).attr('id'),
			'address' 	: 'Tulsa, Ok',
			'zoom' 		: 8
    	}, options);

    var latlng = new google.maps.LatLng(-34.397, 150.644);
      var mapOptions = {
              zoom: settings['zoom'],
              center: latlng,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              scrollwheel: false,
              disableDefaultUI: true,
              panControl: false,
              draggable: false
        }

      settings['id'] = map = new google.maps.Map( document.getElementById(settings['id']), mapOptions);
        
      var geocoder = new google.maps.Geocoder();
      geocoder.geocode( { 'address': settings['address']}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            settings['id'].setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: settings['id'],
                position: results[0].geometry.location
            });
          } else {
            console.log('Geocode was not successful for the following reason: ' + status);
          }
        }); 
  	return this.each(function() {
  			// console.log( $(this).attr('id') );
		});

	};
})( jQuery );