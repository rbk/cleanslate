jQuery(document).ready(function($){

    $('#gurustu_address_submit').click(function(event) {
        event.preventDefault();

        var radius = $('#radiusSelect').val();
        var address = $('#locator_zip').val();
        var results;
        var lat, lng;
        var action = 'gurustu_find_location';
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': address }, function(results,status) {
            if (status == google.maps.GeocoderStatus.OK) {
                
                lng = results[0].geometry.location.jb;
                lat = results[0].geometry.location.kb;

                var data = {
                    action: action,
                    lng: lng,
                    lat: lat,
                    radius: radius
                };

                $.post( guru_ajaxurl.ajaxurl, data, function(response) {

                    var markers = jQuery.parseJSON(response);
                    var center = new google.maps.LatLng(lng,lat);
                    console.log(markers + 'test');
                    named_func( markers, center );

                })


                // $.ajax({

                //     type:'POST',
                //     data: data,
                //     url: guru_ajaxurl.ajaxurl,
                //     cache:false,
                //     async: false,
                //     dataType: "html",
                //     success: function(response){
                //     var markers = jQuery.parseJSON(response);
                //     var center = new google.maps.LatLng(lng,lat);
                //     console.log(markers + 'test2');
                //     named_func( markers, center );
                //         }
                //     })

            } else {
                console.log('fail');
            }
        })        
    });
});

var locator_map ='';
var markers = '';
function named_func(markers, center){

    var bounds = new google.maps.LatLngBounds();
    var center = center;
    var mapOptions = {
        // zoom: 5,
        // maxZoom: 12,
        // minZoom: 10,
        center: center,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        // scrollwheel: false,
        zoomControl: true
    }
    var marker, latlng;
    locator_map = new google.maps.Map( document.getElementById('locator_map_canvas'), mapOptions);

    var template = '';

    for( var i=0; i<markers.length;i++) {

        // Add markers
        latlng = new google.maps.LatLng(markers[i].lng,markers[i].lat);
        marker = new google.maps.Marker({
            position: latlng,
            animation: google.maps.Animation.DROP,
            title: markers[i].name,
            map: locator_map
        });
        bounds.extend(latlng);

        // Add Info Window
        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent('<div style="font-size: 14px;" class="locator_infobox">' + markers[i].name + '<br/>' + markers[i].address + '<br/>' + markers[i].city + ', ' +markers[i].state + '<p><a style="color:blue;text-decoration:underline;font-size:14px;" target="_blank" href="http://maps.google.com/maps?saddr=&daddr=' + markers[i].name + ' ' + markers[i].address + ' ' + markers[i].city + ' ' + markers[i].state +'">Directions</a></p></div>');
                infowindow.open(locator_map, marker);
            }
        })(marker, i));


        // Template for output
        var miles_format = parseFloat( markers[i].distance );
        miles_format = miles_format.toFixed(2);
        template += '<div class="location_list_item"><a href="javascript:set_map_to_this_location('+ markers[i].lat + ',' + markers[i].lng +')" style="height: 54px;width: 100%;display: block;" location-data="' + markers[i].lat + ',' + markers[i].lng + '">';
        template += '<address>' + markers[i].name + '<br/>';
        template += markers[i].address + '<br/>';
        template += markers[i].city + ', ';
        template += markers[i].state + '</address>';
        template += '<span class="miles_away">' + miles_format + ' miles away.</span>';
        template += '</a></div>';

        // Listen fro click on marker
        google.maps.event.addListener(marker, 'click', function() {
            locator_map.setZoom(15);
            locator_map.setCenter(marker.getPosition());
        });

    }
    locator_map.fitBounds(bounds);
    document.getElementById('locator_message_box').innerHTML='"' + markers.length + '" Food Banks found within the selected radius.';
    document.getElementById('locations_list').innerHTML=template;

}
function set_map_to_this_location( lat,lng ){
    latlng = new google.maps.LatLng(lng,lat);
    locator_map.setZoom(15);
    locator_map.panTo(latlng);
}


jQuery(document).ready(function($){

    
    $('#gurustu_address_submit1').click(function(e){
    	
        e.preventDefault();

        var radius = $('#radiusSelect').val();

        // Validate input
        // var zip = $('#locator_zip').val();
        // var zipRegex = /^\d{5}$/;

        // if (!zipRegex.test(zip)) {

        //     $('#locator_message_box').html('Please enter a valid zip/postal code.');
        //     return false;
            
        // }
        // var address = zip;
        var address = $('#locator_zip').val();
        var results;
        var lat, lng;
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': address }, function(results, status) {

       if (status == google.maps.GeocoderStatus.OK) {
            
            lng = results[0].geometry.location.jb;
            lat = results[0].geometry.location.kb;

            // console.log( 'Radius: ' + radius );
            // console.log(lat +', '+ lng); 

            var data = {
                action: 'gurustu_find_location',
                lng: lng,
                lat: lat,
                radius: radius
            };

            $.post( guru_ajaxurl.ajaxurl, data, function(response) {

                var bounds = new google.maps.LatLngBounds();
                var markers = jQuery.parseJSON(response);
                // console.log( markers );

                // console.log( 'Number of results: ' + markers.length );
                
                var center = new google.maps.LatLng(lng,lat);

                var mapOptions = {
                    // zoom: 5,
                    // maxZoom: 12,
                    // minZoom: 10,
                    center: center,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    // scrollwheel: false,
                    zoomControl: true
                }
                var marker, latlng;
                var locator_map = new google.maps.Map( document.getElementById('locator_map_canvas'), mapOptions);

                var template = '';

                if( markers.length > 0 ) {
                      

                        for( var i=0; i<markers.length;i++) {


                            latlng = new google.maps.LatLng(markers[i].lng,markers[i].lat);
                            marker = new google.maps.Marker({
                                position: latlng,
                                animation: google.maps.Animation.DROP,
                                title: markers[i].name,
                                map: locator_map
                            });

                            var infowindow = new google.maps.InfoWindow();

                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    infowindow.setContent('<div style="font-size: 14px;" class="locator_infobox">' + markers[i].name + '<br/>' + markers[i].address + '<br/>' + markers[i].city + ', ' +markers[i].state + '<p><a style="color:blue;text-decoration:underline;font-size:14px;" target="_blank" href="http://maps.google.com/maps?saddr=&daddr=' + markers[i].name + ' ' + markers[i].address + ' ' + markers[i].city + ' ' + markers[i].state +'">Directions</a></p></div>');
                                    infowindow.open(locator_map, marker);
                                }
                            })(marker, i));

                            bounds.extend(latlng);

                            var miles_format = parseFloat( markers[i].distance );
                            miles_format = miles_format.toFixed(2);
                            
                            // build location list Template
                            template += '<div class="location_list_item"><a class="marker'+i+'"href="" style="height: 54px;width: 100%;display: block;" location-data="' + markers[i].lat + ',' + markers[i].lng + '">';
                            template += '<address>' + markers[i].name + '<br/>';
                            template += markers[i].address + '<br/>';
                            template += markers[i].city + ', ';
                            template += markers[i].state + '</address>';
                            template += '<span class="miles_away">' + miles_format + ' miles away.</span>';
                            template += '</a></div>';

                            google.maps.event.addListener(marker, 'click', function() {
                                locator_map.setZoom(15);
                                locator_map.setCenter(marker.getPosition());
                            });
                            // google.maps.event.addListener( $('.marker'+i) , 'click', function(e) {
                            //     e.preventDefault();
                            //     // locator_map.setZoom(15);
                            //     // locator_map.setCenter(marker.getPosition());
                            //     console.log( marker[i].getPosition() );
                            //     return false;
                            // });
                            $('.marker'+i).on('click',function(e){
                                e.preventDefault();
                                locator_map.setCenter(marker.getPosition());
                                return false;
                            })
                        } // end for loop markers

                        locator_map.fitBounds(bounds);
                        $('#locator_message_box').html('"' + markers.length + '" Food Banks found within the selected radius.')
                        $('#locations_list').html(template);

                } else {

                     $('#location_list').html( '"' + markers.length + '" Food Banks found within the selected radius.');

                }
            });

      } else {

        $('#location_list').html('No Food Banks found.')
        console.log('No results');

      }

        });
        
        return false;
    
    });
    
}); // End document ready
function set_cente_loc(ll){

}


// jquery plugin
(function( $ ) {

  //  Example :
  //      $('#map').googleMap({
  //        'address' : 'south padre island, tx',
  //        'zoom' : 15 
  //      });

  $.fn.googleMap = function(options) {

    var settings = $.extend( {
      'id'    : $(this).attr('id'),
      'address'   : 'Tulsa, Ok',
      'zoom'    : 8,
      'infodata'  : 'Default',
      'phone'   : 'Phone Number Not Available',
      'place'   : '',
      'infobox' : false

      }, options);

    // var latlng = new google.maps.LatLng(-34.397, 150.644);
    var center = new google.maps.LatLng(38.8978881835938, -77.0363311767578);
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
          position: results[0].geometry.location,
          visible: false
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
        alert('Geocode was not successful for the following reason: ' + status);
      }
    }); 

    return this.each(function() {
        // console.log( $(this).attr('id') );
    });

  };
  })( jQuery );





jQuery(document).ready(function($){

  // slightly different javascript for the locator widget
  $('#gurustu_address_submit_widget').click(function(e){
        e.preventDefault();

        // Validate input
        var zip = $('#locator_zip_widget').val();
        var zipRegex = /^\d{5}$/;

        if (!zipRegex.test(zip)) {
            $('#locator_message_box').html('Please enter a valid zip/postal code.');
            return false;
        }

        var radius = 1; 
        var address = zip;
        var results;
        var lat, lng;
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': address }, function(results, status) {

       if (status == google.maps.GeocoderStatus.OK) {
            
            lng = results[0].geometry.location.jb;
            lat = results[0].geometry.location.kb;

            // console.log( 'Radius: ' + radius );
            // console.log(lat +', '+ lng); 

            var data = {
                action: 'gurustu_find_location',
                lng: lng,
                lat: lat,
                radius: radius
            };

            $.post( guru_ajaxurl.ajaxurl, data, function(response) {

                // console.log( response );

                var bounds = new google.maps.LatLngBounds();
                var markers = jQuery.parseJSON(response);

                // console.log( 'Number of results: ' + markers.length );
                
                var center = new google.maps.LatLng(lng,lat);

                var mapOptions = {
                    // zoom: 5,
                    // maxZoom: 12,
                    // minZoom: 10,
                    center: center,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    // scrollwheel: false,
                    zoomControl: true
                }
                var marker, latlng;
                var locator_map = new google.maps.Map( document.getElementById('locator_map_canvas_widget'), mapOptions);

                if( markers.length > 0 ) {
                      

                        for( var i=0; i<markers.length;i++) {

                          

                            latlng = new google.maps.LatLng(markers[i].lng,markers[i].lat);
                            marker = new google.maps.Marker({
                                position: latlng,
                                animation: google.maps.Animation.DROP,
                                title: markers[i].name,
                                map: locator_map
                            });

                            var infowindow = new google.maps.InfoWindow();

                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    infowindow.setContent('<div style="font-size: 14px;color:#000;" class="locator_infobox">' + markers[i].name + '<br/>' + markers[i].address + '<br/>' + markers[i].city + ', ' +markers[i].state + '<p><a style="color:blue;text-decoration:underline;font-size:14px;" target="_blank" href="http://maps.google.com/maps?saddr=&daddr=' + markers[i].name + ' ' + markers[i].address + ' ' + markers[i].city + ' ' + markers[i].state +'">Directions</a></p></div>');
                                    infowindow.open(locator_map, marker);
                                }
                            })(marker, i));

                            bounds.extend(latlng);

                      

                        } // end for loop markers
                        locator_map.fitBounds(bounds);
                
                } else {

                     $('#location_list').html( '"' + markers.length + '" Food Banks found within the selected radius.');

                }
            });

      } else {

        $('#location_list').html('No Food Banks found.')
        console.log('No results');

      }


        });
        
        return false;
    
    });

}); 