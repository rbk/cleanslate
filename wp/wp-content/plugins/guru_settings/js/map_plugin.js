// Map plugin
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
      'coordinates' : '36.1539816,-95.992775',
      'zoom'    : 8,
      'infodata'  : 'Default',
      'phone'   : 'Phone Number Not Available',
      'place'   : 'GuRuStu',
      'infobox' : false

      }, options);

    var coordinates = settings['coordinates']
    coordinates = coordinates.split(',');
    lat = parseFloat(coordinates[0]) 
    lng = parseFloat(coordinates[1])

    // console.log( lat + ' ' + lng ) 

    var latlng = new google.maps.LatLng( lat, lng );
    // console.log( latlng )

    var uniqueMapId = settings['id'];
    var infowindow;

    var mapOptions = {
        zoom: settings['zoom'],
        center: latlng,
        mapTypeId: google.maps.MapTypeId.HYBRID,
        scrollwheel: false,
        zoomControl: true,
        disableDefaultUI: true,
        panControl: false,
        draggable: false
    }

    settings['id'] = map = new google.maps.Map( document.getElementById(settings['id']), mapOptions);

    center = settings['id'].getCenter( coordinates );
    map.setCenter(center)

    var marker = new google.maps.Marker({
      map: settings['id'],
      position: center
    });

    if( settings['infobox'] ) {

      var infowindow = new google.maps.InfoWindow();
      google.maps.event.addListener( settings['id'], 'click', function(event) {

        infowindow.setContent('<span id="infobox"><a target="_blank" href="http://maps.google.com/maps?saddr=&daddr=' 
          + settings['place'] + '">Directions to<br/>' 
          +  settings['place'] + '</span></a><br/>' );
        infowindow.open( this, marker);

      });
      // google.maps.event.addListener( settings['id'], 'mouseout', function(event) {
      //   infowindow.close( this, marker);
      //   settings['id'].setCenter(results[0].geometry.location);

      // });
    }
    $(window).resize(function(){
        map.setCenter(center)
    })

    return this.each(function() {
      // not sure what this is for
    });

  };


  })( jQuery );