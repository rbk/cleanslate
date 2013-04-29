jQuery(document).ready(function($){

	// Save location
	$('#location_form').submit(function(){

		// Show loader
		$('#submit').attr('disabled', true);
		$('#ajax-loader').attr('style', 'display:inline');

		// First geocode the address
		var address = $('#location_form input#address').val();
		var city = $('#location_form input#city').val();
		var state = $('#location_form input#state').val();
		address = address + ',' + city + ',' + state;
		var lat, lng;
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': address }, function(results, status) {
			
			if (status == google.maps.GeocoderStatus.OK) {

				lng = results[0].geometry.location.jb;
				lat = results[0].geometry.location.kb;
				$('input#lng').val(lng);
				$('input#lat').val(lat);

				var form_data = $('#location_form input').not(':input[type=submit]');
				
				// Ajax

				var data = {
					action: 'gurustu_save_location',
					form: form_data.serializeArray(),
					guru_nounce: gurustu_vars.guru_nounce

				};

				$.post( ajaxurl, data, function(response) {

					// Hide loader
					$('#submit').attr('disabled', false);
					$('#ajax-loader').attr('style', 'display:none');

					$('#message').html( '<p>Location Saved!.</p>').show();

					// clear the form data
					form_data.each(function(){
						$(this).val('');
					});

				});


			} else {

				alert('There was an unexpected error from Google. Please check the address and try again.');

			}
	      	
		});

		return false;	
	}); // End save location function

	// Delete
	$('a.delete').click(function(e){
		e.preventDefault();

		var id = $(this).attr('href');
		$(this).parent().parent().get(0).remove();

		var data = {
			action: 'gurustu_delete_location',
			id: id
		};

		$.post( ajaxurl, data, function(response) {
			$('#message').html( '<p>Location Deleted!.</p>').show();
		});
	})

	// Edit
	$('a.edit, div#locations_list tbody tr').click(function(e){
		e.preventDefault();

		var id = $(this).attr('href');

		var data = {
			action: 'gurustu_single_location',
			id: id
		};

		$.post( ajaxurl, data, function(response) {

			// alert( response );

		});
	})

	$('#map_preview_button').click(function(e){

		e.preventDefault();
		
		var address = $('#location_form input#address').val();
		var city = $('#location_form input#city').val();
		var state = $('#location_form input#state').val();

		if( address == '' || city == '' || state == '' ){
			address = 'South Padre Island, TX';
		} else {
			address = address + ',' + city + ',' + state;
		}

		$('#map_preview').googleMap({
			'address' : address,
			'zoom' : 15 
		});

	})

	$('#import_csv').submit(function(){

		$('input[type=submit]').attr('disabled', true);
		$('#ajax-loader').attr('style', 'display:inline');

		var csv_path = $('#csv-file').val();

		var data = {
			action: 'gurustu_import_csv',
			csv: csv_path
		};

		$.post( ajaxurl, data, function(response) {

			// console.log( response );
			$('input[type=submit]').attr('disabled', false);
			$('#ajax-loader').attr('style', 'display:none');

		});

		return false;
	})


});

//   jQuery(function ($) {
//         $('#test').click( get_coordinates( '8146 s 77th east ave, tulsa, ok' ) );
//     });

// function get_coordinates( address ) {
// 	var apiKey = 'AIzaSyAIKWLF2zm-hukmc6Z9eTDhL6Xfg1iXz_0';
//   //   var lat, lng;
//   //   var geocoder = new google.maps.Geocoder();
//   //   geocoder.geocode( { 'address': address }, function(results, status) {
//   //     if (status == google.maps.GeocoderStatus.OK) {
//   //       lng = results[0].geometry.location.jb;
//   //       lat = results[0].geometry.location.kb;
// 		// return 'test';
//   //     }

//   //   });

// 	jQuery.getJSON("http://maps.google.com/maps/geo?q="+ address +"&key="+ apiKey +"&sensor=false&output=json&callback=?",
// 	function(data, textStatus){
// 	// console.log(data);
// 	return data;
// 	});
// }




// Plugins

// jquery plugin
(function( $ ) {

  //  Example :
  //      $('#map').googleMap({
  //        'address' : 'south padre island, tx',
  //        'zoom' : 15 
  //      });

  $.fn.googleMap = function( options ) {

    var settings = $.extend( {
      'id'    : $(this).attr('id'),
      'address'   : 'Tulsa, Ok',
      'zoom'    : 8,
      'infodata'  : 'Default',
      'phone'   : 'Phone Number Not Available',
      'place'   : '',
      'infobox' : false

      }, options);

    var center = new google.maps.LatLng(-97.168404, 26.106644);
    var geocoder = new google.maps.Geocoder();
    var uniqueMapId = settings['id'];
    var infowindow;

    var mapOptions = {
		zoom: settings['zoom'],
		center: center,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false,
		zoomControl: true
    }

    settings['id'] = map = new google.maps.Map( document.getElementById(settings['id']), mapOptions);

    geocoder.geocode( { 'address': settings['address']}, function(results, status) {

      if (status == google.maps.GeocoderStatus.OK) {

        settings['id'].setCenter(results[0].geometry.location);

        var marker = new google.maps.Marker({
          map: settings['id'],
          position: results[0].geometry.location
        });

        if( settings['infobox'] ) {

          var infowindow = new google.maps.InfoWindow();
          google.maps.event.addListener( settings['id'], 'mouseover', function(event) {

            infowindow.setContent('<span><a target="_blank" href="http://maps.google.com/maps?saddr=&daddr=' 
              + settings['place'] + '">Click here to get Directions<br/> to ' 
              +  settings['place'] + '</span></a><br/>' );
            infowindow.open( this, marker);

          });

          google.maps.event.addListener( settings['id'], 'mouseout', function(event) {
            infowindow.close( this, marker);
            settings['id'].setCenter(results[0].geometry.location);

          });
        }
    	
      } else {

      	console.log('Status:' + status);
	        
      }
    }); 

    return this.each(function() {
        // console.log( $(this).attr('id') );
    });

  };
  })( jQuery );